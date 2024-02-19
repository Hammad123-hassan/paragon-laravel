<div x-data="{
    observe() {
        let observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    @this.call('loadMore')
                }
            })
        }, {
            root: null
        })

        observer.observe(this.$el)
    }
}" x-init="observe">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/js/app.js') --}}
    <style>
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .listing:hover span {
            color: #fff;
        }

        .box-shadow {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .chat-shadow {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        }


       


        #menu {
            list-style: none;
            padding: 0;
            position: absolute;
            right: 0;
            top: 50px;
            width: 100%;
            border-radius: 0px 0px 10px 10px;
            background: #fff
        }

        #menu li {
            border-bottom: 1px solid #e5e7eb;
            padding: 6px 30px;

        }

        #menu li:hover {
            background-color:  #005974;

        }

        #menu li:hover a {
            color: #fff
        }

        #menu li:last-child {
            border: none
        }

        #menu a {
            text-decoration: none;
            color:  #005974
        }

    </style>
    <div class="container mx-auto" x-data="{{ json_encode(['messages' => $messages, 'messageBody' => '']) }}">
        <div class="min-w-full   rounded-lg lg:grid lg:grid-cols-3 box-shadow">
            <div class="border-r border-gray-300 lg:col-span-1">

                <div class="mx-3 my-3">
                    <div class="relative text-gray-600">
                        <span class="absolute inset-y-0  left-0 flex items-center pl-2">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5 text-[#005974]">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input wire:keydown.enter="getLeadList"wire:model.live="search" type="text" style="border-color: #005974;"
                            class="block w-full py-2 pl-10 bg-gray-100 shadow-lg rounded-md outline-none border-[#005974] focus:border-1 placeholder:text-[#005974] placeholder:text-[12px]"
                            placeholder="Search" />
                    </div>
                </div>


                <ul class="overflow-auto rounded-t-[10px] h-[28rem]  no-scrollbar">
                    <div
                        class="py-3 px-2  bg-[#0979CC] relative border-b-[1px] border-white  flex items-center justify-between">
                        <h2 class="text-white text-gray-600 uppercase text-sm font-semibold">
                            Chats</h2>
                        <div class="flex items-center">
                            <button id="toggleButton"><svg class="w-4 h-4 text-gray-800 text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg></button>
                            <ul id="menu" class="hidden shadow-2xl">
                               
                            <li wire:click="getStatus('all')"><a  href="#" class="text-xs  font-semibold">All</a></li>
                                @foreach(config('status') as $item)
                                @if($item != 'Lead')
                                <li wire:click="getStatus('{{ $item }}')"><a  href="#" class="text-xs  font-semibold">{{ $item }}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <li>
                        @foreach ($leadList as $item)
                            <a wire:click="getLeadChat('{{ $item->id }}')"
                                class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-[#0979CC] focus:outline-none listing {{ $item->id == $lead['id'] ? 'bg-gray-100' : '' }}">
                                @if ($item->getFirstMediaUrl('profile-images'))
                                    <img class=" box-shadow object-cover w-10 h-10 rounded-full"
                                        src="{{ $item->getFirstMediaUrl('profile-images') }}" alt="img" />
                                @else
                                    <img class=" box-shadow object-cover w-10 h-10 rounded-full"
                                        src="https://www.gravatar.com/avatar/94d0fd152a573b2d3623127a3f0074a2?s=80&d=mp&r=g"
                                        alt="img" />
                                @endif
                                <div class="w-full pb-2">
                                    <div class="flex justify-between">
                                        <span class="block ml-2 font-semibold text-gray-600">{{ $item->name }} |
                                            {{ $item->id }}</span>                       
                                        @php
                                            $lastMessage = $item
                                                ->messages()
                                                ->orderBy('id', 'desc')
                                                ->pluck('created_at')
                                                ->first();
                                            
                                            $timestamp = \Carbon\Carbon::parse($lastMessage);
                                            $now = \Carbon\Carbon::now();
                                            $diffInMinutes = $now->diffInMinutes($timestamp);
                                            
                                            if ($diffInMinutes < 60) {
                                                $timeAgo = $diffInMinutes . ' minutes ago';
                                            } elseif ($diffInMinutes < 1440) {
                                                // Less than 24 hours
                                                $timeAgo = round($diffInMinutes / 60) . ' hours ago';
                                            } else {
                                                $timeAgo = $timestamp->format('M j, Y g:i A');
                                            }
                                        @endphp
                                        @if ((int) $timeAgo > 0)
                                            <span
                                                class="block ml-2  text-gray-600 text-[10px]">{{ $timeAgo }}</span>
                                        @endif
                                    </div>
                                    @php
                                        $content = $item
                                            ->messages()
                                            ->orderBy('id', 'desc')
                                            ->pluck('body')
                                            ->first();
                                        if (preg_match('/<[^<]+>/', $content) !== 0) {
                                            $content = 'File';
                                        } else {
                                            $content;
                                        }
                                    @endphp
                                    <span class="block ml-2 text-sm text-gray-600 ">
                                        {{ Str::limit($content, 30) }}</span>
                                </div>
                                
                            </a>
                        @endforeach

                    </li>
                </ul>
            </div>
            @if ($lead['id'])
                <div class="hidden lg:col-span-2 lg:block">
                    <div class="w-full">
                        <div class="relative flex items-center p-3 border-b border-gray-300  justify-between">
                          <div class="flex items-center gap-2">
                            @if ($lead->getFirstMediaUrl('profile-images'))
                            <img class="object-cover box-shadow w-10 h-10 rounded-full"
                                src="{{ $lead->getFirstMediaUrl('profile-images') }}" alt="username" />
                        @else
                            <img class="object-cover box-shadow w-10 h-10 rounded-full"
                                src="https://www.gravatar.com/avatar/94d0fd152a573b2d3623127a3f0074a2?s=80&d=mp&r=g"
                                alt="username" />
                        @endif
                        <span class="block ml-2 font-bold  text-[#0979CC] font-bold">{{ $lead->name }}</span>
                          </div>
                          <div style="cursor: pointer;" wire:click="getInformation()">
                            <svg class="w-6 h-6 text-[#0979CC] dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 14">
                                <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                  <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                  <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                                </g>
                              </svg>
                          </div>

                        </div>
                        <div class="relative w-full p-6 overflow-y-auto h-[29rem] no-scrollbar" x-ref="messageContainer" >
                            <ul class="space-y-2">
                                @if ($currentChatId)
                                @foreach ($messages as $item)
                                    @php
                                        $timestamp = \Carbon\Carbon::parse($item['created_at']);
                                        $now = \Carbon\Carbon::now();
                                        $diffInMinutes = $now->diffInMinutes($timestamp);
                                        
                                        if ($diffInMinutes < 60) {
                                            $timeAgo = $diffInMinutes . ' minutes ago';
                                        } elseif ($diffInMinutes < 1440) {
                                            // Less than 24 hours
                                            $timeAgo = round($diffInMinutes / 60) . ' hours ago';
                                        } else {
                                            $timeAgo = $timestamp->format('M j, Y g:i A');
                                        }
                                    @endphp
                                    @if ($item['created_by'] == auth()->user()->id)
                                        <li class="flex justify-end" >
                                            <div
                                                class="relative max-w-xl px-4 py-2 text-gray-700 bg-[#eff2f7] rounded-[8px] rounded-br-none chat-shadow flex justify-between items-end">
                                                <span>
                                                    <span class="block text-xs">{!! $item['body'] !!} </span>
                                                    <p class="block text-[10px]" aria-setsize="small">
                                                        {{ $timeAgo }}</p>
                                                </span>
                                            </div>
                                        </li>
                                    @else
                                        <li class="flex justify-start" >
                                            <div
                                                class="relative max-w-xl dark:bg-white px-4 py-2 text-gray-700  chat-shadow bg-[#556ee61a] rounded-[8px] rounded-bl-none"  >
                                                <span>
                                                    <p class="text-sm  text-[#0979CC]  font-semibold">
                                                        {{ $item->sender->name }}
                                                    </p>
                                                    <span class="block text-xs">{!! $item['body'] !!}</span>
                                                    <p class="block text-[10px]" aria-setsize="small">
                                                        {{ $timeAgo }}</p>
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                @endif

                            </ul>
                        </div>

                        <div class="flex items-center justify-between w-full p-3 border-t border-gray-300">
                            {{-- <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button> --}}
                            {{-- <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <input type="file" name="" id="">
                    </button> --}}
                            <div class="upload-btn-wrapper">
                                <button class="btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#0979CC]"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <input wire:model='attachment' type="file" name="myfile" />
                            </div>

                            <input type="text" placeholder="Message"
                                @keydown.enter="
                    @this.call('sendMessage', messageBody)
                    messageBody = ''
                    "
                                x-model="messageBody"
                                class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                                name="message" required />

                            <button
                                @click="
                    @this.call('sendMessage', messageBody)
                    messageBody = ''
                ">
                                <svg class="w-5 h-5  text-[#0979CC] origin-center transform rotate-90"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if($lead['id'])
        <x-filament::modal slide-over width="3xl"  id="edit-user">
            {{-- <x-slot name="trigger">
                <x-filament::button>
                    Open modal
                </x-filament::button>
            </x-slot> --}}

            <div>
                <div class="w-full bg-[#EBF2F6]  p-2 mt-5 mb-5">
                    <h3
                        class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Personal Information <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $lead->status }}</span>
                    </h3>

                </div>
                <div class="grid grid-cols-3 gap-x-5 gap-y-0 mx-0 my-3 mb-0">
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Region/Branch
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white mb-1 mt-1">{{ $lead->region->name ?? null }} | {{ $lead->branch->name ?? null }}</p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Counsellor
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $lead->user->name }}
                        </p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Name
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $lead->name }}
                            </p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Email
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">
                            {{ $lead->email }}</p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Phone
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $lead->phone }}
                        </p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            City
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $lead->city ?? null }}</p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            CNIC
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $lead->cnic ?? null }}</p>
                    </div>
                    <div class="mb-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            DOB
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">
                            @if($lead->dob)
                            {{ date('d-M-Y', strtotime($lead->dob)) }}
                            @endif
                        </p>
                    </div>
                    <div class="mb-0">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Degree
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white mb-0 mt-2">{{ $lead->degree->name }}</p>
                    </div>
                    <div class="mb-0">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Intake
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white mb-0 mt-2">{{ $lead->intake->name }}</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="w-full bg-[#EBF2F6]  p-2 mt-5 mb-5">
                    <h3
                        class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Other Information
                    </h3>

                </div>
                <div class="grid grid-cols-5 gap-x-5 gap-y-0 mx-0 my-3 mb-0">
                    <div class="mb-1 col-span-1">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Apply Country
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white">
                        <ul>
                           @foreach($lead->countries as $country)
                            <li class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{$country->name}}</li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                    <div class="mb-1  col-span-2">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Apply Universities
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white ">
                        <ul>

                            @foreach($lead->applyUniversity as $item)
                            <li class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">
                                {{ $item->name }}</li>
                                @endforeach

                        </ul>
                        </p>

                    </div>
                    <div class="mb-1  col-span-2">
                        <span class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                            Apply Degress
                        </span>
                        <p class="text-xs font-normal leading-6 text-gray-950 dark:text-white ">
                        <ul>

                            @foreach($lead->degrees as $degree)
                            <li class="text-xs font-normal leading-6 text-gray-950 dark:text-white  mb-1 mt-1">{{ $degree->name }}</li>
                            @endforeach

                        </ul>
                        </p>
                    </div>


                </div>
            </div>
            <div>
                <div class="w-full bg-[#EBF2F6]  p-2 mt-5 mb-5">
                    <h3
                        class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Applied Universities
                    </h3>

                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    University

                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Applied URL

                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Admitted
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Admitted Degree
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lead->universities as $item)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="text-xs font-normal leading-6 text-gray-950 dark:text-white  px-6 py-4">
                                    {{ $item->university->name }}
                                </th>
                                <th scope="row"
                                    class="text-xs font-normal leading-6 text-gray-950 dark:text-white  px-6 py-4">
                                    {{ $item->applied_url }}
                                </th>
                                <td class="text-xs font-normal leading-6 text-gray-950 dark:text-white  px-6 py-4">
                                    @if($item->admitted == 0)
                                    Yes
                                    @else
                                    No
                                    @endif
                                </td>
                                <td class="text-xs font-normal leading-6 text-gray-950 dark:text-white  px-6 py-4">{{ $item->degree->name }}
                                </td>

                            </tr>
                            @endforeach
                           

                        </tbody>
                    </table>
                </div>


            </div>
            {{-- Modal content --}}
        </x-filament::modal>
        @endif
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('8b2ba67ad9f24ee8abd2', {
            cluster: 'ap2',
            encrypted: true
        });
        const channel = pusher.subscribe('messaging-development');
        channel.bind('channel-name-messaging', function(data) {
            @this.incomingMessage(data)
        });
    </script>
    <script>
        // Get references to the button and menu
        const toggleButton = document.getElementById('toggleButton');
        const menu = document.getElementById('menu');

        // Add a click event listener to the button
        toggleButton.addEventListener('click', (event) => {
            // Prevent the click event from propagating to the document body
            event.stopPropagation();
            // Toggle the "hidden" class on the menu
            menu.classList.toggle('hidden');
        });

        // Add a click event listener to the document body
        document.body.addEventListener('click', () => {
            // Hide the menu if it's not already hidden
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
    <script>
        function scrollToBottom() 
        {
        const messageContainer = document.querySelector('[x-ref="messageContainer"]');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight - messageContainer.clientHeight;
        }
        }

        document.addEventListener('DOMContentLoaded', function () 
        {
            Livewire.on('scroll-to-bottom', () => {
                scrollToBottom();
            });
        });
    </script>

</div>
