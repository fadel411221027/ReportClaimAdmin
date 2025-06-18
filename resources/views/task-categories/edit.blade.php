<x-app-layout>
    <x-slot name="header">
        <h2 class="text-primary font-semibold text-2xl leading-tight">
            {{ __('Edit Tugas Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border-2 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('task-categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Name</label>
                            <input type="text" name="name" value="{{ $category->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_dor_date" {{ $category->has_dor_date ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">DOR</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_batch" {{ $category->has_batch ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Batch</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_claim" {{ $category->has_claim ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Claim</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_time_range" {{ $category->has_time_range ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Time Range</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_sheets" {{ $category->has_sheets ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Sheets</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_email" {{ $category->has_email ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Email</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label justify-start gap-2">
                                    <input type="checkbox" name="has_form" {{ $category->has_form ? 'checked' : '' }} class="checkbox checkbox-primary" />
                                    <span class="label-text">Form</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-secondary font-bold py-2 px-4 rounded">
                                Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
