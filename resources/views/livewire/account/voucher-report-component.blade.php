<div class="">
    <div class="shadow bg-white">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container mx-auto ">
                <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                    <img src="/Report.svg" alt="" class="h-[25px]">
                    <h1 class="breadcrumb-item text-sm text-white text-center font-bold">Voucher Report</h1>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section>
            <div class="container mx-auto pb-4">
                <div>
                    <div>
                        @include('livewire.message.success')
                        @include('livewire.message.error')
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4 pb-0">
                        <div class="col-span-3">
                            <div class="mb-4">
                                <label for="start_date" class="block text-xs font-medium text-[#4B465C] mb-1.5">Start
                                    Date</label>
                                <input type="date" wire:model="startDate"
                                    class="{{ $errors->has('data.voucher_date') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs ">
                            </div>
                        </div>
                        <div class="col-span-3">
                            <div class="mb-4">
                                <label for="end_date" class="block text-xs font-medium text-[#4B465C] mb-1.5">End
                                    Date</label>
                                <input type="date" wire:model="endDate"
                                    class="{{ $errors->has('data.voucher_date') ? 'border-red-500' : '' }} form-input border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs ">
                            </div>
                        </div>
                        @if (!auth()->user()->hasRole('Counsellor'))
                            <div class="col-span-3">
                                <label for="selectedBranch"
                                    class="block text-xs font-medium text-[#4B465C] mb-1.5">Branches</label>
                                <select wire:model="selectedBranch"
                                    class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-span-3">
                            <div class="mb-4">
                                <label for="selectedType"
                                    class="block text-xs font-medium text-[#4B465C] mb-1.5">Voucher Type</label>
                                <select wire:model="selectedType"
                                    class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5 text-[#040404] text-xs">

                                    @foreach ($typeOptions as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end ">
                        <button wire:click="generateReport"
                            class="p-3 rounded text-xs font-semibold text-white  mt-0 m-4 mb-5 bg-[#00969B] hover:bg-[#005974]">Generate
                            Report</button>
                    </div>
                </div>
                @if ($vouchers ?? null)
                    @if ($vouchers->count() > 0)
                        <div class="m-4 mt-0 mx-4 overflow-x-auto">
                            <table class="table table-hover w-full  whitespace-nowrap">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-start p-3 py-4 text-white  bg-[#00969B] rounded-tl-lg
                                        font-semibold text-xs border-[#E5E7EB] border border-l-0 border-t-0">
                                            Type</th>
                                        <th
                                            class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                            Voucher #</th>
                                        <th
                                            class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                            Date Created</th>
                                        <th
                                            class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                            User Name</th>
                                            <th
                                            class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                            Branch</th>
                                        <th
                                            class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border rounded-tr-lg border-r-0 border-t-0 border-[#E5E7EB]r">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher)
                                        <tr>
                                            <td  class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">{{ $typeOptions[$voucher->type] ?? '' }}</td>
                                            <td  class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">{{ $voucher->voucher_no }}</td>
                                            <td  class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">{{ $voucher->voucher_date }}</td>
                                            <td  class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">{{ $voucher->users->name ?? '' }}</td>
                                            <td class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">
                                                @if (isset($voucher->users->branches) && $voucher->users->branches->isNotEmpty())
                                                {{ $voucher->users->branches->pluck('name')->implode(', ') }}
                                            @else
                                                Nill 
                                            @endif
                                            
                                            </td>
                                            <td  class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">
                                                <button wire:click="getInformation({{ $voucher->id }})"
                                                    class="">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-eye" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="1"
                                                        stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>

                                                </button>
                                                @if (now()->startOfDay()->lte($voucher->created_at))
                                                    <button wire:click="softDeleteConfirmation({{ $voucher->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-trash" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="1"
                                                            stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12">
                                                            </path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>

                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="mt-6 p-6">
                            <p>No vouchers found for the selected criteria.</p>
                        </div>
                    @endif
                @endif
            </div>
        </section>
        {{-- @if (count($getvoucher) > 0) --}}
            <x-filament::modal slide-over width="3xl" id="edit-user">
                <div class="modal-content">
                    <h2 class="  text-black bg-white text-sm font-bold ">Voucher Details</h2>
                    <div class="mx-4 overflow-x-auto  ">
                        <table class="w-full border-collapse mt-6 whitespace-nowrap ">
                            <thead>
                                <tr>
                                    <th class="text-start p-3 text-[#4B465C] font-semibold text-xs border">Account ID</th>
                                    <th class="text-start p-3 text-[#4B465C] font-semibold text-xs border">Narration</th>
                                    <th class="text-start p-3 text-[#4B465C] font-semibold text-xs border">Debit Amount</th>
                                    <th class="text-start p-3 text-[#4B465C] font-semibold text-xs border">Credit Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getvoucher as $item)
                                    <tr>
                                        <td class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">
                                            {{ $item->chart->account_number ?? '' }}-{{ $item->chart->title }}-<b>({{ $item->chart->subAccountGet() }})</b>
                                        </td>
                                        <td class="border">
                                            <div
                                                class="text-start p-4 py-3 font-semibold text-xs flex items-start justify-between gap-1">
                                                <div class="overflow-hidden"
                                                    style="max-width: 300px; white-space: nowrap; word-wrap: break-all;">
                                                    <span
                                                        class="text-ellipsis white-nowrap overflow-hidden block max-w-[300px]">
                                                        {{ $item->memo }}
                                                    </span>
                                                </div>
                                                @if (strlen($item->memo) > 60)
                                                    <button class="read-more-button text-blue-500 text-xs whitespace-nowrap"
                                                        onclick="showMore(this)">See
                                                        More</button>
                                                    <button class="read-less-button text-blue-500 hidden whitespace-nowrap"
                                                        onclick="showLess(this)">See
                                                        Less</button>
                                                @endif
                                            </div>
                                        </td>
    
    
                                        <td class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">
                                            {{ $item->debit_amount }}</td>
                                        <td class="text-start p-4 py-3 font-semibold text-xs text-[#005974] border">
                                            {{ $item->credit_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  
                </div>
             
            </x-filament::modal>
        {{-- @endif --}}
    </div>
    <script>
        window.addEventListener('confirm-delete', function() {
            Swal.fire({
                title: 'Delete Voucher?',
                text: 'Are you sure you want to delete this voucher?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('softDelete');
                }
            });
        });

        window.addEventListener('close-delete-modal', function() {
            Swal.close();
        });
    </script>
    <script>
        function showMore(button) {
            const div = button.parentNode;
            const hiddenText = div.querySelector('.overflow-hidden');
            const readMoreButton = div.querySelector('.read-more-button');
            const readLessButton = div.querySelector('.read-less-button');
            hiddenText.style.maxWidth = '400px'; // Set the maximum width to 400px
            hiddenText.style.whiteSpace = 'normal'; // Allow line breaks
            hiddenText.style.wordWrap = 'break-word'; // Break long words
            readMoreButton.style.display = 'none';
            readLessButton.style.display = 'inline';
        }

        function showLess(button) {
            const div = button.parentNode;
            const hiddenText = div.querySelector('.overflow-hidden');
            const readMoreButton = div.querySelector('.read-more-button');
            const readLessButton = div.querySelector('.read-less-button');
            hiddenText.style.maxWidth = '300px'; // Set the maximum width back to 300px
            hiddenText.style.whiteSpace = 'nowrap'; // Prevent line breaks
            hiddenText.style.wordWrap = 'break-all'; // Reset word-wrap
            readMoreButton.style.display = 'inline';
            readLessButton.style.display = 'none';
        }
    </script>
</div>
