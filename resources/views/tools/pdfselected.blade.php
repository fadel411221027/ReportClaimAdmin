<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Selected PDF') }}</h2>
        </div>
    </x-slot>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .rotate-0 { transform: rotate(0deg); }
        .rotate-90 { transform: rotate(90deg); }
        .rotate-180 { transform: rotate(180deg); }
        .rotate-270 { transform: rotate(270deg); }
    </style>

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 mx-4 rounded-xl shadow-xl bg-base-100">
            <div class="card">
                <!-- Drop zone and other existing content remains the same -->
                <div class="mb-8">
                    <div id="dropZone" class="p-8 border-2 border-dashed shadow-xl transition-all duration-300 card bg-base-100 border-primary/50 hover:border-primary">
                        <input type="file" id="fileInput" multiple accept=".pdf" class="hidden">
                        <label for="" class="block text-center cursor-pointer">
                            <div class="floating">
                                <svg class="mx-auto w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold">Jatuhkan file pdf disini</h3>
                            <p class="mt-2 text-sm text-base-content/70">atau klik disini untuk memilih berkas</p>
                        </label>
                    </div>
                </div>

                <div id="loading" class="hidden mt-6 text-center">
                    <span class="loading loading-spinner loading-lg text-primary"></span>
                </div>

                <div id="pageContainer" class="hidden pb-4 mt-10">
                    <!-- Existing buttons -->
                    <div class="flex flex-wrap gap-3 justify-start items-center px-5 mb-6">
                        <button id="invertSelection" class="shadow-lg transition-all duration-300 btn btn-secondary btn-sm hover:btn-secondary-focus">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            Pilihan pembalik
                        </button>
                        <button id="rotateAllPages" class="shadow-lg transition-all duration-300 btn btn-info btn-sm hover:btn-info-focus">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Putar Semua
                        </button>
                        <button id="clearPages" class="shadow-lg transition-all duration-300 btn btn-error btn-sm hover:btn-error-focus">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Halaman
                        </button>
                        <button id="splitButton" class="shadow-lg transition-all duration-300 btn btn-primary btn-sm hover:btn-primary-focus">
                            Unduh Pdf
                        </button>
                        <button id="downloadSeparateButton" class="shadow-lg transition-all duration-300 btn btn-accent btn-sm hover:btn-accent-focus">
                            Unduh Terpisah
                        </button>
                    </div>

                    <div id="pageGrid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-8"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // Existing variable declarations
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const loading = document.getElementById('loading');
        const pageContainer = document.getElementById('pageContainer');
        const pageGrid = document.getElementById('pageGrid');
        const splitButton = document.getElementById('splitButton');
        const invertSelection = document.getElementById('invertSelection');
        const clearPages = document.getElementById('clearPages');
        const rotateAllPages = document.getElementById('rotateAllPages');

        let currentFile = null;
        let selectedPages = new Set();
        let pageOrder = [];
        let pageRotations = new Map(); // Track rotation state for each page

        // Initialize Sortable
        new Sortable(pageGrid, {
            animation: 150,
            ghostClass: 'bg-base-500',
            onEnd: function(evt) {
                const items = Array.from(pageGrid.children);
                pageOrder = items.map(item => parseInt(item.dataset.pageNum));
            }
        });

        // Pilihan pembalik
        invertSelection.addEventListener('click', () => {
            const allPages = Array.from(pageGrid.children);
            allPages.forEach(pageDiv => {
                const pageNum = parseInt(pageDiv.dataset.pageNum);
                togglePage(pageNum, pageDiv);
            });
        });

        // Rotasi Semua PDF
        rotateAllPages.addEventListener('click', () => {
            const allPages = Array.from(pageGrid.children);
            allPages.forEach(pageDiv => {
                const pageNum = parseInt(pageDiv.dataset.pageNum);
                rotatePage(pageNum);
            });
        });

        // Existing event listeners remain the same
        [['dragover', handleDragOver], ['dragleave', handleDragLeave], ['drop', handleDrop]]
            .forEach(([event, handler]) => dropZone.addEventListener(event, handler));

        dropZone.addEventListener('click', (e) => {
            if (e.target.closest('label')) {
                fileInput.click();
            }
        });
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file?.type === 'application/pdf') handleFile(file);
        });

        // Modified clear pages to also clear rotations
        clearPages.addEventListener('click', () => {
            currentFile = null;
            selectedPages.clear();
            pageOrder = [];
            pageRotations.clear();
            pageGrid.innerHTML = '';
            pageContainer.classList.add('hidden');
            fileInput.value = '';
        });

        // Existing event handlers remain the same
        function handleDragOver(e) {
            e.preventDefault();
            dropZone.classList.add('border-primary/70', 'bg-base-200');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            dropZone.classList.remove('border-primary/70', 'bg-base-200');
        }

        function handleDrop(e) {
            e.preventDefault();
            dropZone.classList.remove('border-primary/70', 'bg-base-200');
            const file = e.dataTransfer.files[0];
            if (file?.type === 'application/pdf') handleFile(file);
        }

        // Rotasi file PDF
        function rotatePage(pageNum) {
            const currentRotation = pageRotations.get(pageNum) || 0;
            const newRotation = (currentRotation + 90) % 360;
            pageRotations.set(pageNum, newRotation);

            const pageImage = document.querySelector(`[data-page-num="${pageNum}"] img`);
            pageImage.className = pageImage.className.replace(/rotate-\d+/, '') + ` rotate-${newRotation}`;
        }

        async function handleFile(file) {
            currentFile = file;
            selectedPages.clear();
            pageOrder = [];
            pageRotations.clear();
            loading.classList.remove('hidden');
            pageContainer.classList.add('hidden');
            pageGrid.innerHTML = '';

            try {
                const arrayBuffer = await file.arrayBuffer();
                const pdf = await pdfjsLib.getDocument(arrayBuffer).promise;

                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = page.getViewport({ scale: 0.5 });
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    await page.render({
                        canvasContext: context,
                        viewport: viewport
                    }).promise;

                    const pageDiv = document.createElement('div');
                    pageDiv.dataset.pageNum = i;
                    pageDiv.className = 'relative group cursor-move';
                    pageDiv.innerHTML = `
                        <div class="relative aspect-[0.707] rounded-box overflow-hidden border-2 border-primary transition-all">
                            <img src="${canvas.toDataURL()}" class="object-contain w-full h-full transition-transform duration-300 rotate-0" alt="Page ${i}">
                            <div class="absolute inset-0 opacity-0 transition-opacity bg-base-300 group-hover:opacity-50"></div>
                            <div class="absolute right-0 bottom-0 left-0 p-2 text-center bg-opacity-75 bg-base-300">
                                Halaman ${i}
                            </div>
                            <button class="absolute top-2 right-2 p-2 text-white rounded-full opacity-0 transition-opacity rotate-btn bg-primary group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    `;

                    const rotateBtn = pageDiv.querySelector('.rotate-btn');
                    rotateBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        rotatePage(i);
                    });

                    selectedPages.add(i);
                    pageOrder.push(i);
                    pageDiv.addEventListener('click', (e) => {
                        if (!e.target.closest('.rotate-btn')) {
                            togglePage(i, pageDiv);
                        }
                    });
                    pageGrid.appendChild(pageDiv);
                }

                pageContainer.classList.remove('hidden');
            } catch (error) {
                console.error('Error loading PDF:', error);
            } finally {
                loading.classList.add('hidden');
            }
        }

        // Modified splitButton click handler to include rotations
        splitButton.addEventListener('click', async () => {
            if (!currentFile || selectedPages.size === 0) return;

            splitButton.disabled = true;
            splitButton.innerHTML = '<span class="loading loading-spinner"></span> Processing...';

            try {
                const arrayBuffer = await currentFile.arrayBuffer();
                const pdfDoc = await PDFLib.PDFDocument.create();
                const originalPdf = await PDFLib.PDFDocument.load(arrayBuffer);

                const orderedSelectedPages = pageOrder.filter(pageNum => selectedPages.has(pageNum));
                const pageIndexes = orderedSelectedPages.map(num => num - 1);
                const pages = await pdfDoc.copyPages(originalPdf, pageIndexes);

                pages.forEach((page, index) => {
                    const pageNum = orderedSelectedPages[index];
                    const rotation = pageRotations.get(pageNum) || 0;
                    page.setRotation(PDFLib.degrees(rotation));
                    pdfDoc.addPage(page);
                });

                const newPdfBytes = await pdfDoc.save();
                const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                const originalFileName = currentFile.name.replace('.pdf', '');
                link.download = `${originalFileName}_rcaSelected.pdf`;
                link.click();
                URL.revokeObjectURL(url);
            } catch (error) {
                console.error('Error splitting PDF:', error);
            } finally {
                splitButton.disabled = false;
                splitButton.textContent = 'Unduh Pdf';
            }
        });

        // Existing togglePage function remains the same
        function togglePage(pageNum, pageDiv) {
            if (selectedPages.has(pageNum)) {
                selectedPages.delete(pageNum);
                pageDiv.querySelector('.border-2').classList.remove('border-primary');
                pageDiv.querySelector('.border-2').classList.add('border-base-300');
                pageDiv.classList.add('opacity-50');
            } else {
                selectedPages.add(pageNum);
                pageDiv.querySelector('.border-2').classList.add('border-primary');
                pageDiv.querySelector('.border-2').classList.remove('border-base-300');
                pageDiv.classList.remove('opacity-50');
            }
        }

        //Unduh Terpisah
        // Replace the existing downloadSeparateButton event listener with this improved version
        document.getElementById('downloadSeparateButton').addEventListener('click', async () => {
            if (!currentFile || selectedPages.size === 0) return;

            const button = document.getElementById('downloadSeparateButton');
            button.disabled = true;
            button.innerHTML = '<span class="loading loading-spinner"></span> Processing...';

            try {
                const arrayBuffer = await currentFile.arrayBuffer();
                const originalPdf = await PDFLib.PDFDocument.load(arrayBuffer);
                const orderedSelectedPages = pageOrder.filter(pageNum => selectedPages.has(pageNum));
                const originalFileName = currentFile.name.replace('.pdf', '');
                
                // Create a status message element
                const statusDiv = document.createElement('div');
                statusDiv.className = 'mt-4 p-4 bg-info text-info-content rounded-lg';
                statusDiv.innerHTML = `Preparing to download ${orderedSelectedPages.length} files...`;
                pageContainer.appendChild(statusDiv);
                
                // Process pages in batches of 5 with delays between batches
                const batchSize = 5;
                for (let i = 0; i < orderedSelectedPages.length; i += batchSize) {
                    const batch = orderedSelectedPages.slice(i, i + batchSize);
                    statusDiv.innerHTML = `Downloading batch ${Math.floor(i/batchSize) + 1} of ${Math.ceil(orderedSelectedPages.length/batchSize)}...`;
                    
                    // Process each page in the current batch
                    await Promise.all(batch.map(async (pageNum) => {
                        const singleDoc = await PDFLib.PDFDocument.create();
                        const [page] = await singleDoc.copyPages(originalPdf, [pageNum - 1]);
                        
                        const rotation = pageRotations.get(pageNum) || 0;
                        page.setRotation(PDFLib.degrees(rotation));
                        singleDoc.addPage(page);
                        
                        const pdfBytes = await singleDoc.save();
                        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `${originalFileName}_Halaman_${pageNum}_rcaSelected.pdf`;
                        link.click();
                        
                        // Small delay to prevent browser from blocking downloads
                        await new Promise(resolve => setTimeout(resolve, 100));
                        URL.revokeObjectURL(url);
                    }));
                    
                    // Add a delay between batches to give the browser time to process downloads
                    if (i + batchSize < orderedSelectedPages.length) {
                        statusDiv.innerHTML = `Waiting before next batch...`;
                        await new Promise(resolve => setTimeout(resolve, 2000));
                    }
                }
                
                statusDiv.innerHTML = `All ${orderedSelectedPages.length} files have been processed!`;
                setTimeout(() => {
                    statusDiv.remove();
                }, 5000);
                
            } catch (error) {
                console.error('Error creating separate PDFs:', error);
            } finally {
                button.disabled = false;
                button.textContent = 'Unduh Terpisah';
            }
        });


    </script>
</x-app-layout>
