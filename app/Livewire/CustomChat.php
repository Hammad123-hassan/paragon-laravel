<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use App\Models\Lead;
use App\Models\Message;
use Livewire\Component;
use Pusher;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
// use Livewire\WithFileUploads;

class CustomChat extends Component
{
    use WithPagination;
    // use WithFileUploads;
    public $attachment;
    public $search;
    public $user;
    public $lead;
    public $status;
    public $messages = [];
    public $perPage = 10;
    public $currentChatId = null;
    

    public function updatedAttachment()
    {

        $uploadedFile = $this->attachment->store('files', 'public');

        $mimeType = $this->attachment->getMimeType();

        // dd($this->attachment->getClientOriginalName());
        $originalName = $this->attachment->getClientOriginalName();
        // Check if it's an image
        if (Str::startsWith($mimeType, 'image/')) {

            $this->sendMessage("<img src='/storage/$uploadedFile'>");
            // It's an image
            // You can process it or store it as needed
        } else {
            // It's not an image (e.g., it's a different type of file)
            // Handle accordingly
            $svg = '<span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
          </svg>
            </span>';
            $this->sendMessage("<a href='/storage/$uploadedFile'>$originalName  $svg</a>");
        }
    }

    public function getLeadList()
    {

        $this->user = auth()->user();
        $leadList = Lead::select('leads.*')
            ->leftJoin('messages', 'leads.id', '=', 'messages.lead_id')
            ->whereNot('leads.status', 'Lead')
            ->orderByRaw('MAX(messages.created_at) DESC')
            ->groupBy('leads.id');
        if ($this->user->roles[0]->id == 3) {
            $leadList->where('leads.created_by', $this->user->id);
        }
        if ($this->user->roles[0]->id == 2) {
            $branchesId = $this->user->branches->pluck('id')->toArray();
            $leadList->whereIn('leads.branch_id', $branchesId);
        }
        if ($this->status && $this->status != 'all') {

            $leadList->where('leads.status', $this->status);
        }
        if ($this->search) {
            $leadList->where('leads.name', 'like', '%' . $this->search . '%')
                ->orWhere('leads.id', 'like', '%' . $this->search . '%');
        }

        return $leadList;
    }

    public function getInformation()
    {

        $this->dispatch('open-modal', id: 'edit-user');
    }

    public function getStatus($status)
    {
        $this->status = $status;
    }



    public function getLeadChat($lead)
    {

        $data = Lead::find($lead);
        $this->lead = $data;
        $this->messages = $this->lead->messages;

        $this->currentChatId = $this->lead->id;
    }
    public function mount()
    {
        $this->lead['id'] = null;
    }
    public function sendMessage($body)
    {
        // dd('asd');
        if (!$body) {
            $this->addError('messageBody', 'Message body is required.');
            return;
        }

        $message = Message::forceCreate([
            'body' => $body,
            'lead_id' => $this->lead['id'],
            'branch_id' => $this->lead['branch_id'],
            'created_by' => $this->user->id,
        ]);

        $this->dispatch('scroll-to-bottom');
        
        $app_id = '1664894';
        $app_key = '8b2ba67ad9f24ee8abd2';
        $app_secret = 'e36ea4fdb85e9a0dd4c1';
        $app_cluster = 'ap2';
        $options = [
            'cluster' => $app_cluster,
            'useTLS' => false
        ];
       

        $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, $options);
        $pusher->trigger('messaging-development', 'channel-name-messaging', $message);

        
    }

    /**
     * @param $message
     */
    public function incomingMessage($message)
    {
        // $this->getLeadChat($message['lead_id']);
        // $this->getLeadList();
        if ($message['lead_id'] == $this->currentChatId) {
            $this->getLeadChat($message['lead_id']);
            
        }
       
    }

    public function render()
    {

        return view('livewire.custom-chat', ['leadList' => $this->getLeadList()->paginate($this->perPage)]);
    }
    public function loadMore()
    {
        $this->perPage += 10;
    } 
    
}
