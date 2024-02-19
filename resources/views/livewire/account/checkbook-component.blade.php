<div class="">
    <style>
    </style>
    <!-- Content Header (Page header) -->
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
            <div class="flex  items-center gap-3">
                <img src="/Checkbook.svg" alt="" class="h-[25px]">
                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Checkbook</h1>
            </div>
            <div>
                @if ($viewStatus)
                    <button
                        class="p-3 rounded text-xs font-semibold text-[#00969B] btn-checkbook hover:text-white bg-white hover:bg-[#005974]"
                        wire:click="admissionList">ChequeBook List</button>
                @else
                <button
                    class="p-3 rounded text-xs font-semibold text-[#00969B]  hover:text-white bg-white hover:bg-[#005974]"
                    wire:click="addNewBank">Add ChequeBook</button>
                @endif
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container mx-auto">
            <div>
                @include('livewire.message.success')
                @include('livewire.message.error')
            </div>
            <div class="flex">
                @if ($viewStatus)
                <div class="w-full bg-white">
                    <div class="card card-custom card-outline">
                        <div class="">
                            <div class="grid md:grid-cols-3 grid-cols-1 gap-2 p-4">
                                <div class="">
                                    <div class="form-group">
                                        <label for="bank_name"
                                            class="block text-xs font-medium text-[#4B465C] mb-1.5">Bank Name
                                        </label>
                                        <input id="bank_name" wire:model="data.bank_name" type="text"
                                            class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs  placeholder:text-[#040404]"
                                            id="inputError" placeholder="Enter bank name">
                                        @error('data.bank_name')
                                        <span class="text-red-500">Field is required</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="format" class="block text-xs font-medium text-[#4B465C] mb-1.5">
                                            Cheque format
                                        </label>
                                        <input id="format" wire:model="data.format" type="text"
                                            class="{{ $errors->has('data.format') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs  placeholder:text-[#040404]"
                                            id="inputError" placeholder="Enter start serial">
                                        @error('data.format')
                                        <span class="text-red-500">Field is required</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="pages"
                                            class="block text-xs font-medium text-[#4B465C] mb-1.5">Checkbook end
                                            serial
                                        </label>
                                        <select wire:model='data.pages'
                                            class="form-control border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404]">
                                            <option value="">Select checkbook pages</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        {{-- <input id="end_serial" wire:model="data.end_serial" type="text"
                                            class="{{ $errors->has('data.end_serial') ? 'border-red-500' : '' }}
                                        form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404]
                                        text-xs "
                                        id="inputError" placeholder="Enter end serial"> --}}
                                        @error('data.pages')
                                        <span class="text-red-500">Field is required</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="flex items-center mb-4 mt-2">
                                    <input wire:model='data.active' id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Active</label>
                                </div> --}}
                            </div>
                            <div class="text-right">
                                <button id="submitBtn" wire:loading.attr='disabled' wire:click="store" type="submit"
                                    class="p-3 rounded text-xs font-semibold text-white  m-3 my-5 bg-[#00969B] hover:bg-[#005974] mt-0">
                                    Create Checkbook
                                    <div wire:loading wire:target="store" class="spinner-border spinner-border-sm"
                                        role="status">
                                    </div>
                                </button>
                            </div>
                        </div>
                        <!-- /.card body -->
                    </div>
                </div>
                @else
                <div class="w-full">
                   <div>
                        {{ $this->table }}
                   </div>
                </div>
                @endif
                <!-- /.col -->
            </div>
            <!-- ./row -->
        </div><!-- /.container -->
    </section>
    <!-- /.content -->
</div>
