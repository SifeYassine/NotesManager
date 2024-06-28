<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto" style="width: 30vw;">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Categories Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="padding-left: 35px; border: 0px">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td style="padding: 15px 0 0 20px;"><div style="background-color: #f5eba2; border: 3px solid #f7e733; border-radius: 8px; width: 80px; height: 35px; display: grid; place-items: center">{{ $category->name }}</div></td>
                                    <td>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="padding-left: 15vw;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
