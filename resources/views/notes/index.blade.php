<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="width: 65vw;">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Notes Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="padding-left: 70px; border: 0px">Title</th>
                                <th style="padding-left: 60px; border: 0px">Content</th>
                                <th style="padding-left: 20px; border: 0px">Category</th>
                                <th style="padding-left: 60px; border: 0px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                                <tr>
                                    <td style="padding: 20px 0 0 20px;">{{ $note->title }}</td>
                                    <td style="padding: 20px 0 0 20px;"><p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis; max-width: 200px;">{{ $note->content }}</p></td>
                                    <td style="padding: 15px 0 0 20px;"><div style="background-color: #f5eba2; border: 3px solid #f7e733; border-radius: 8px; width: 80px; height: 35px; display: grid; place-items: center">{{ $note->category->name }}</div></td>
                                    <td>
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewNoteModal{{ $note->id }}">
                                            🔍
                                        </button>
                                        
                                        <!-- View Note Modal -->
                                        <div class="modal fade" id="viewNoteModal{{ $note->id }}" tabindex="-1" aria-labelledby="viewNoteModalLabel{{ $note->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewNoteModalLabel{{ $note->id }}">View Note Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Title:</strong></p>
                                                        <p>{{ $note->title }}</p>
                                                        <p><strong>Content:</strong></p>
                                                        <p>{{ $note->content }}</p>
                                                        <p><strong>Category:</strong> <div style="background-color: #f5eba2; border: 3px solid #f7e733; border-radius: 8px; width: 80px; height: 35px; display: grid; place-items: center">{{ $note->category->name }}</div></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editNoteModal{{ $note->id }}">
                                            ✏️
                                        </button>
                                        
                                        <!-- Edit Note Modal -->
                                        <div class="modal fade" id="editNoteModal{{ $note->id }}" tabindex="-1" aria-labelledby="editNoteModalLabel{{ $note->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editNoteModalLabel{{ $note->id }}">Edit Note</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('notes.update', $note->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="edit_title{{ $note->id }}">Note Title</label>
                                                                <input type="text" name="title" id="edit_title{{ $note->id }}" class="form-control" value="{{ $note->title }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_content{{ $note->id }}">Content</label>
                                                                <textarea name="content" id="edit_content{{ $note->id }}" class="form-control" required>{{ $note->content }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_category{{ $note->id }}">Category</label>
                                                                <select name="category" id="edit_category{{ $note->id }}" class="form-control" required>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $note->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Form -->
                                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $notes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
