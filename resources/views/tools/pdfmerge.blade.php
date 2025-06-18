<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Merge PDF') }}</h2>
        </div>
    </x-slot>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }dragover
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .file-preview {
            position: relative;
            width: 100%;
            height: 350px;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .file-preview img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
        }

        .file-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
        }
    </style>

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 mx-4 rounded-xl shadow-xl bg-base-100">
            <div class="card">
                <div class="mb-8">
                    <div id="dropZone" class="p-8 border-2 border-dashed shadow-xl transition-all duration-300 card bg-base-100 border-primary/50 hover:border-primary">
                        <input type="file" id="fileInput" multiple accept=".pdf,.png,.jpg,.jpeg,.webp" class="hidden">
                        <label for="fileInput" class="block text-center cursor-pointer">
                            <div class="floating">
                                <svg class="mx-auto w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold">Jatuhkan file disini</h3>
                            <p class="mt-2 text-sm text-base-content/70">atau klik disini untuk memilih beberapa berkas</p>
                            <p class="mt-1 text-xs text-base-content/50">Mendukung: PDF, PNG, JPG</p>
                        </label>
                    </div>
                </div>

                <div id="loading" class="hidden mt-6 text-center">
                    <span class="loading loading-spinner loading-lg text-primary"></span>
                </div>

                <div id="fileContainer" class="hidden pb-4 mt-10">
                    <div class="flex flex-wrap gap-3 justify-start items-center px-5 mb-6">
                        <button id="clearFiles" class="shadow-lg transition-all duration-300 btn btn-error btn-sm hover:btn-error-focus">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Semua
                        </button>
                        <button id="sortByName" class="shadow-lg transition-all duration-300 btn btn-secondary btn-sm hover:btn-secondary-focus">
                            Urutkan berdasarkan nama
                        </button>
                        <button id="mergeButton" class="shadow-lg transition-all duration-300 btn btn-primary btn-sm hover:btn-primary-focus">
                            Gabung File
                        </button>
                    </div>

                    <div id="fileGrid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const loading = document.getElementById('loading');
        const fileContainer = document.getElementById('fileContainer');
        const fileGrid = document.getElementById('fileGrid');
        const mergeButton = document.getElementById('mergeButton');
        const clearFiles = document.getElementById('clearFiles');
        const sortByName = document.getElementById('sortByName');

        let files = [];
        let thumbnails = new Map();

        // Initialize Sortable
        new Sortable(fileGrid, {
            animation: 150,
            ghostClass: 'bg-base-500',
            onEnd: function(evt) {
                // Get the old and new positions
                const oldIndex = evt.oldIndex;
                const newIndex = evt.newIndex;

                // Update the files array to match the new visual order
                const itemMoved = files.splice(oldIndex, 1)[0];
                files.splice(newIndex, 0, itemMoved);
            }
        });

        // Add this event listener for the sort by name button
        sortByName.addEventListener('click', () => {
            // Sort the files array by filename
            files.sort((a, b) => {
                return a.file.name.localeCompare(b.file.name);
            });

            // Refresh the grid to show the new order
            refreshFileGrid();
        });


        // Event Listeners
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary/70', 'bg-base-200');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary/70', 'bg-base-200');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary/70', 'bg-base-200');
            const droppedFiles = Array.from(e.dataTransfer.files);
            if (droppedFiles.length > 0) handleFiles(droppedFiles);
        });

        fileInput.addEventListener('change', (e) => {
            const selectedFiles = Array.from(e.target.files);
            if (selectedFiles.length > 0) handleFiles(selectedFiles);
        });

        clearFiles.addEventListener('click', () => {
            files = [];
            thumbnails.clear();
            fileGrid.innerHTML = '';
            fileContainer.classList.add('hidden');
            fileInput.value = '';
        });

        // File preview generator
        async function generatePreview(file) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = async (e) => {
                    let preview = '';
                    let details = '';

                    if (file.type.includes('pdf')) {
                        const arrayBuffer = await file.arrayBuffer();
                        const pdf = await pdfjsLib.getDocument(arrayBuffer).promise;
                        const page = await pdf.getPage(1);
                        const viewport = page.getViewport({ scale: 1.5 });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        await page.render({ canvasContext: context, viewport }).promise;
                        preview = canvas.toDataURL();
                        details = `PDF - ${pdf.numPages} halaman`;
                    } else if (file.type.includes('image')) {
                        preview = e.target.result;
                        details = `Image - ${file.type.split('/')[1].toUpperCase()}`;
                    } else if (file.type.includes('word')) {
                        // Use a generic document icon for Word files
                        preview = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzODQgNTEyIj48cGF0aCBkPSJNMzY1LjMgOTMuMzggbC03NC42OS03NC42OUEzMiAzMiAwIDAgMCAyNTguOSAwSDQ4QzIxLjUgMCAwIDIxLjUgMCA0OHY0MTZjMCAyNi41IDIxLjUgNDggNDggNDhoMjg4YzI2LjUgMCA0OC0yMS41IDQ4LTQ4di0zNDEuM2MwLTguNDgtMy4zNy0xNi42Mi05LjM3LTIyLjYzek0zMzYgNDQ4SDQ4di00MTZoMjA4djkwLjMxYzAgMjEuNDkgMjUuNzEgMzIuMjQgNDAuODEgMTcuMTRMMzM2IDEwMC4zdjM0Ny43eiIvPjwvc3ZnPg==';
                        details = 'Word Document';
                    }

                    resolve({ preview, details });
                };
                reader.readAsDataURL(file);
            });
        }

        // Handle files
        async function handleFiles(newFiles) {
            loading.classList.remove('hidden');
            try {
                for (const file of newFiles) {
                    if (!isValidFile(file)) continue;

                    const preview = await generatePreview(file);
                    files.push({
                        file: file,
                        preview: preview.preview,
                        details: preview.details
                    });
                }

                refreshFileGrid();
                if (files.length > 0) {
                    fileContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error handling files:', error);
                showToast('Error processing files', 'error');
            } finally {
                loading.classList.add('hidden');
            }
        }

        // Refresh file grid
        function refreshFileGrid() {
            fileGrid.innerHTML = '';
            files.forEach((fileData, index) => {
                const div = document.createElement('div');
                div.className = 'file-preview';
                div.innerHTML = `
                    <img src="${fileData.preview}" alt="${fileData.file.name}">
                    <div class="file-info">
                        <div class="text-sm truncate">${fileData.file.name}</div>
                        <div class="text-xs opacity-75">${fileData.details}</div>
                    </div>
                    <button onclick="removeFile(${index})" class="absolute top-2 right-2 btn btn-error btn-sm btn-circle">×</button>
                `;
                fileGrid.appendChild(div);
            });
        }

        // File validation
        function isValidFile(file) {
            const validTypes = [
                'application/pdf',
                'image/jpeg',
                'image/png',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];

            if (!validTypes.includes(file.type)) {
                showToast(`${file.name} memiliki format yang tidak didukung`, 'warning');
                return false;
            }

            const maxSize = 10 * 1024 * 1024; // 10MB
            if (file.size > maxSize) {
                showToast(`${file.name} terlalu besar (maksimal 10MB)`, 'warning');
                return false;
            }

            return true;
        }

        // Remove file
        function removeFile(index) {
            files.splice(index, 1);
            refreshFileGrid();
            if (files.length === 0) {
                fileContainer.classList.add('hidden');
            }
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'error' ? 'bg-error text-error-content' :
                type === 'warning' ? 'bg-warning text-warning-content' :
                'bg-success text-success-content'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // Merge files
        mergeButton.addEventListener('click', async () => {
            if (files.length === 0) return;

            mergeButton.disabled = true;
            mergeButton.innerHTML = '<span class="loading loading-spinner"></span> Processing...';
            loading.classList.remove('hidden');

            try {
                const mergedPdf = await PDFLib.PDFDocument.create();

                for (const fileData of files) {
                    const file = fileData.file;
                    let pdfBytes;

                    try {
                        // Handle PDF files
                        if (file.type === 'application/pdf') {
                            pdfBytes = await file.arrayBuffer();
                        }
                        // Handle image files
                        else if (file.type.includes('image')) {
                            const img = await createImageBitmap(file);
                            const tempPdf = await PDFLib.PDFDocument.create();






                            // Create a new page with image dimensions
                            const imageBytes = await file.arrayBuffer();
                            let pdfImage;

                            if (file.type === 'image/jpeg') {
                                pdfImage = await tempPdf.embedJpg(imageBytes);
                            } else if (file.type === 'image/png') {
                                pdfImage = await tempPdf.embedPng(imageBytes);
                            }

                            // Get the dimensions of the image
                            const { width: imgWidth, height: imgHeight } = await pdfImage.scale(1);





                            // Create page with original image dimensions
                            const page = tempPdf.addPage([imgWidth, imgHeight]);






                            // Draw the image at original size
                            page.drawImage(pdfImage, {




                                x: 0,
                                y: 0,
                                width: imgWidth,
                                height: imgHeight,
                            });

                            pdfBytes = await tempPdf.save();
                        }

                    // Handle Word documents (DOC/DOCX)
                    else if (file.type.includes('word')) {
                        // First convert Word to HTML using Mammoth
                        const arrayBuffer = await file.arrayBuffer();
                        const result = await mammoth.convertToHtml({ arrayBuffer });
                        const htmlContent = result.value;

                        // Create a temporary PDF for the Word content
                        const pdfDoc = await PDFLib.PDFDocument.create();
                        const page = pdfDoc.addPage();
                        const { width, height } = page.getSize();
                        const font = await pdfDoc.embedFont(PDFLib.StandardFonts.Helvetica);

                        // Convert HTML content to plain text with line breaks preserved
                        let text = htmlContent.replace(/<[^>]*>/g, ' ');
                        // Collapse multiple spaces to single spaces
                        text = text.replace(/\s+/g, ' ');
                        // Preserve line breaks
                        text = text.replace(/(\r\n|\n|\r)/gm, '\n');
                        text = text.trim();

                        const fontSize = 20;
                        const margin = 50;
                        const maxWidth = width - margin * 2;
                        const lineHeight = fontSize * 1.2;
                        let currentY = height - margin;
                        let textLines = text.split('\n');


                        for (const line of textLines) {
                            // Wrap long lines
                            const wrappedLines = wrapLines(line, maxWidth, fontSize, font);

                            for (const wrappedLine of wrappedLines) {

                                page.drawText(wrappedLine, {
                                    x: margin,
                                    y: currentY,
                                    size: fontSize,
                                    font,
                                });

                                currentY -= lineHeight;

                                if (currentY < margin) {
                                    page = pdfDoc.addPage();
                                    currentY = height - margin;
                                }
                            }

                        }

                        pdfBytes = await pdfDoc.save();
                    }

                    // Helper function to wrap long lines of text
                    function wrapLines(text, maxWidth, fontSize, font) {

                        const words = text.split(' ');
                        const lines = [];
                        let currentLine = '';

                        for (const word of words) {
                            const testLine = currentLine.length > 0 ? `${currentLine} ${word}` : word;
                            const textWidth = font.widthOfTextAtSize(testLine, fontSize);

                            if (textWidth > maxWidth) {
                                lines.push(currentLine);
                                currentLine = word;
                            } else {
                                currentLine = testLine;
                            }
                        }

                        lines.push(currentLine);
                        return lines;

                    }


                        // Merge the converted PDF into the main document
                        const pdf = await PDFLib.PDFDocument.load(pdfBytes);
                        const pages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                        pages.forEach(page => mergedPdf.addPage(page));

                    } catch (error) {
                        console.error(`Error processing file ${file.name}:`, error);
                        showToast(`Failed to process ${file.name}`, 'error');
                    }
                }

                    const mergedPdfBytes = await mergedPdf.save();
                    const blob = new Blob([mergedPdfBytes], { type: 'application/pdf' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'rcaMergedPdf.pdf';
                    link.click();
                    URL.revokeObjectURL(url);

                    showToast('File berhasil digabung!');
                } catch (error) {
                    console.error('Error merging files:', error);
                    showToast('Gagal menggabung file. Silakan coba lagi.', 'error');
                } finally {
                    mergeButton.disabled = false;
                    mergeButton.textContent = 'Gabung File';
                    loading.classList.add('hidden');
                }
            });
    </script>
</x-app-layout>
