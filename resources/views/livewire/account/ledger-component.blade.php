<div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
        <div class="container mx-auto">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <?xml version="1.0" encoding="UTF-8"?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" id="Layer_1" data-name="Layer 1"
                    viewBox="0 0 24 24" width="25" height="25">
                    <path
                        d="M18,0H6A3,3,0,0,0,3,3V23.9l3.67-2.51,2.671,1.826,2.666-1.826,2.666,1.826,2.664-1.825L21,23.9V3A3,3,0,0,0,18,0ZM15,14H7V12h8Zm2-5H7V7H17Z" />
                </svg>


                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Ledger</h1>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content bg-white">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-span-12">
                    <div class="card card-custom card-outline">
                        {{-- <div
                            class="card-header p-4 border-b border-gray-200 bg-[#00969B] text-white font-semibold text-sm">
                            <h3 class="card-title text-base text-white-700">
                                Account Ledger
                            </h3>
                        </div> --}}
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-4">
                                <div class="">
                                    <div class="form-group">
                                        @if ($errors->has('date_from'))
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="inputError"><i class="far fa-times-circle"></i>
                                                {{ $errors->first('date_from') }}
                                            </label>
                                        @else
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="date_from">Date From</label>
                                        @endif
                                        <input id="date_from" wire:model="date_from" type="date"
                                            class="form-control  border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs{{ $errors->has('date_from') ? 'is-invalid' : '' }}"
                                            id="inputError" placeholder="Enter your name">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        @if ($errors->has('date_to'))
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="inputError"><i class="far fa-times-circle"></i>
                                                {{ $errors->first('date_to') }}
                                            </label>
                                        @else
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="date_to">Date To</label>
                                        @endif
                                        <input id="date_to" wire:model="date_to" type="date"
                                            class="form-control  border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs{{ $errors->has('date_to') ? 'is-invalid' : '' }}"
                                            id="inputError" placeholder="Enter your name">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="custom-select" wire:ignore>
                                        @if ($errors->has('parttaker_id'))
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="inputError"><i class="far fa-times-circle"></i>
                                                {{ $errors->first('parttaker_id') }}
                                            </label>
                                        @else
                                            <label
                                                class="col-form-label  block text-xs font-medium text-[#4B465C] mb-1.5"
                                                for="account">Accounts</label>
                                        @endif
                                        <select id="account" onchange="getAccountId()" name="parttaker_id"
                                            class="parttaker_id sub-account border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs{{ $errors->has('account') ? 'is-invalid' : '' }}">
                                            <option>Select Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->account_number }}
                                                    {{ $account->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-end justify-end">
                                <button wire:loading.attr='disabled' wire:click="getData" type="submit"
                                    class="p-3 rounded text-xs font-semibold text-white  mt-0 m-4 mb-4 bg-[#00969B] hover:bg-[#005974]">
                                    Submit
                                    <div wire:loading wire:target="getData" class="spinner-border spinner-border-sm"
                                        role="status">
                                    </div>
                                </button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <div class="row px-4">
                <div class="col-span-12">
                    <div class="card pb-4">
                        <div class="card-header">
                            {{-- <h3 class="card-title">Expandable Table</h3> --}}
                        </div>
                        <!-- ./card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-full">
                                    <thead>
                                        <tr class="">
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] rounded-tl-lg
                                            font-semibold text-xs border-[#E5E7EB] border border-l-0 border-t-0r">
                                                Voucher#</th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Date
                                            </th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Narration</th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Debit
                                            </th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Credit</th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border rounded-tr-lg border-r-0 border-t-0 border-[#E5E7EB]">
                                                Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                            <th
                                                class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]  border  border-r-0">
                                            </th>
                                            <th
                                                class="text-start  p-3 py-4 font-semibold text-xs text-[#005974] border border-l-0 border-r-0">
                                            </th>
                                            <th colspan="3"
                                                class="text-[#4B465C] text-start  p-3 py-4 font-bold text-xs  border border-l-0 ">
                                                Opening
                                                Balance</th>

                                            <th class="text-[#4B465C] text-start  p-3 py-4 font-bold text-xs  border">
                                                {{ abs($openingBalance) }} {{ $openingBalance > 0 ? 'DR' : 'CR' }}
                                            </th>
                                        </tr>
                                        @foreach ($ledger as $item)
                                            <tr>
                                                <td class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                                    {{ $item->id }}</td>
                                                <td class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                                    {{ $item->voucher_date }}</td>
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
                                                            <button
                                                                class="read-more-button text-blue-500 text-xs whitespace-nowrap"
                                                                onclick="showMore(this)">See
                                                                More</button>
                                                            <button
                                                                class="read-less-button text-blue-500 hidden whitespace-nowrap"
                                                                onclick="showLess(this)">See
                                                                Less</button>
                                                        @endif
                                                    </div>
                                                </td>


                                                <td class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                                    {{ $item->debit_amount }}</td>
                                                <td class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                                    {{ $item->credit_amount }}</td>
                                                @php
                                                    $closingBalance = $item->debit_amount - $item->credit_amount + $openingBalance;
                                                    $openingBalance = $closingBalance;
                                                @endphp
                                                <td class="text-start  p-3 py-4 font-semibold text-xs text-[#005974]">
                                                    {{ abs($closingBalance) }}
                                                    {{ $closingBalance > 0 ? 'DR' : 'CR' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- ./row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Initialize Select2 with the 'minimumResultsForSearch' option
            $('.sub-account').select2({
                minimumResultsForSearch: 0, // Set this value to 0 to always show the search input
            });

            // Listen for the 'select2:select' event
            $('.sub-account').on('select2:select', function(e) {
                // Handle the selection here
                console.log('Selection changed:', e.params.data);
                @this.set('data.account_id', e.params.data.id);
            });
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

        function getAccountId() {
            var inputElement = document.querySelector(".parttaker_id").value;
            @this.parttaker_id = inputElement;
        }
    </script>
</div>
