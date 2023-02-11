<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class EditChannel extends Component
{

    use AuthorizesRequests;
    use WithFileUploads;

    public $channel;
    public $image;

    protected function rules()
    {

        return [

            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'nullable|max:1000',
            'image' => 'nullable|image|max:1024',

        ];
    }


    public function mount(Channel $channel)
    {

        $this->channel = $channel;
    }
    public function render()
    {
        return view('livewire.channel.edit-channel');
    }

    public function update()
    {

        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([

            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,

        ]);

        //check if image is submitted

        if ($this->image) {
            //save the image

            $image = $this->image->storeAs('images', $this->channel->uid . '.png');

            //update file path in the db

            $this->channel->update([
                'image' => $image
            ]);
        }

        session()->flash('message', 'Channel updated');

        return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);
    }
}
