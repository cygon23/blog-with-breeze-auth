<div>
    <form wire:submit='create' action="">
        @if (session('success'))
            <span>{{ session('success') }}</span>
        @endif
        <input class="block rounded border border-black-100 px-3 py-1 mb-1" wire:model='name' type="text" placeholder="name">
        @error('name')
            <span class="text-danger-500 text-xs">{{ $message }}</span>
        @enderror
         <input class="block rounded border border-gray-100 px-3 py-1 mb-1"wire:model='email'  type="email" placeholder="email">
         @error('email')
            <span class="text-danger-500 text-xs">{{ $message }}</span>
        @enderror
          <input class="block rounded border border-gray-100 px-3 py-1 mb-1" wire:model='password'  type="password" placeholder="password">
         @error('password')
            <span class="text-danger-500 text-xs">{{ $message }}</span>
        @enderror
          <button  class="block rounded px-3 py-1 bg-gray-400 text=white">create</button>
    </form>

    @foreach ($users as $user )
        <h3>{{ $user->name }}</h3>
    @endforeach

    {{ $users->links() }}
</div>

