<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div id="note-container" class="p-3">
                    <section id="note-header" class="mt-3">
                        <h3 class="text-center">NOTES APP</h3>
                    </section>
                    <section id="note-errors">
                        <div
                            v-if="createNoteForm.errors.length > 0"
                            class="alert alert-warning alert-dismissible fade show"
                            role="alert"
                        >
                            <span
                                v-for="(error, index) in createNoteForm.errors"
                                :key="index"
                                >{{ error }}</span
                            >
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div
                            v-if="createNoteForm.isCreated"
                            class="alert alert-success alert-dismissible fade show"
                            role="alert"
                        >
                            <span>Note item created successfully</span>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div
                            v-if="editNoteForm.isUpdated"
                            class="alert alert-success alert-dismissible fade show"
                            role="alert"
                        >
                            <span>Note item updated successfully</span>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </section>
                    <section id="add-note-form" class="my-3">
                        <form>
                            <div
                                class="d-flex justify-content-between align-items-center"
                            >
                                <input
                                    v-model="createNoteForm.name"
                                    v-on:keyup.enter="addNote"
                                    minlength="5"
                                    maxlength="50"
                                    placeholder="Enter note name and press enter"
                                    type="text"
                                    class="form-control mr-3"
                                />
                                <button
                                    v-if="createNoteForm.isSubmitting"
                                    class="btn btn-primary"
                                    type="button"
                                    disabled
                                >
                                    <span
                                        class="spinner-grow spinner-grow-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="sr-only">Loading...</span>
                                </button>
                                <button
                                    v-else
                                    @click.prevent="addNote"
                                    class="btn btn-primary"
                                >
                                    Add
                                </button>
                            </div>
                        </form>
                    </section>
                    <section id="note-actions"></section>
                    <section id="note-list">
                        <ul class="list-group">
                            <div v-if="notes.isLoading" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <li
                                v-if="!notes.isLoading && notes.data.length > 0"
                                v-for="note in notes.data"
                                :key="note.uuid"
                                class="list-group-item"
                            >
                                <div
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    {{ note.name }}
                                    <span
                                        class="d-flex justify-content-between align-items-center"
                                    >
                                        <a
                                            class="text-success mr-2"
                                            href="#"
                                            @click.prevent="
                                                showEditNoteForm(note)
                                            "
                                        >
                                            <i class="fa fa-edit"> </i> Edit
                                        </a>
                                        <a
                                            class="text-danger"
                                            href="#"
                                            @click.prevent="destroy(note)"
                                        >
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </span>
                                </div>
                                <div
                                    class="d-flex w-100 justify-content-between"
                                >
                                    <small class="text-muted">Created</small>
                                    <small class="text-muted">{{
                                        note.created_at
                                    }}</small>
                                </div>
                            </li>
                            <li
                                v-if="
                                    !notes.isLoading && notes.data.length === 0
                                "
                                class="list-group-item list-group-item-action list-group-item-warning"
                            >
                                No note items found.
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="editNoteItemModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="editNoteItemModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNoteItemModalLabel">
                            Update NoteItem
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="edit-note-errors" class="mb-3">
                            <div
                                v-if="editNoteForm.errors.length > 0"
                                class="alert alert-warning alert-dismissible fade show"
                                role="alert"
                            >
                                <span
                                    v-for="(error,
                                    index) in editNoteForm.errors"
                                    :key="index"
                                    >{{ error }}</span
                                >
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </section>
                        <section id="edit-note">
                            <form>
                                <div
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <input
                                        v-model="editNoteForm.name"
                                        v-on:keyup.enter="updateNote"
                                        minlength="5"
                                        maxlength="50"
                                        placeholder="Enter note name and press enter"
                                        type="text"
                                        class="form-control mr-3"
                                    />
                                    <button
                                        v-if="editNoteForm.isSubmitting"
                                        class="btn btn-primary"
                                        type="button"
                                        disabled
                                    >
                                        <span
                                            class="spinner-grow spinner-grow-sm"
                                            role="status"
                                            aria-hidden="true"
                                        ></span>
                                        <span class="sr-only">Loading...</span>
                                    </button>
                                    <button
                                        v-else
                                        @click.prevent="updateNote"
                                        class="btn btn-success"
                                    >
                                        Update
                                    </button>
                                </div>
                            </form>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoteList",
    data() {
        return {
            notes: {
                isLoading: false,
                data: []
            },
            createNoteForm: {
                isSubmitting: false,
                isCreated: false,
                name: undefined,
                errors: []
            },
            editNoteForm: {
                isSubmitting: false,
                isUpdated: false,
                uuid: undefined,
                name: undefined,
                errors: []
            },
            error: undefined
        };
    },
    mounted() {
        this.loadNotes();
    },
    methods: {
        showEditNoteForm(note) {
            this.editNoteForm.name = note.name;
            this.editNoteForm.uuid = note.uuid;
            $("#editNoteItemModal").modal("show");
        },
        /**
         * Loads notes
         */
        loadNotes() {
            // update loader to loading
            this.notes.isLoading = true;

            axios
                .get("/notes")
                .then(response => {
                    this.notes.data = response.data;
                })
                .catch(error => {
                    //TODO: update with your logic on how to handle this error.
                    console.log(error.message);
                    this.error =
                        "Unable to load notes. View log for more information";
                })
                .finally(() => {
                    // disable loader
                    this.notes.isLoading = false;
                });
        },

        /**
         * Create a NoteItem.
         * Uses payload in the this.createNoteForm param
         */
        addNote() {
            // update loader to loading
            this.createNoteForm.isSubmitting = true;
            // Use can use this as the payload.
            // const noteData = { name: this.createNoteForm.name };
            axios
                .post("/notes", this.createNoteForm)
                .then(response => {
                    this.createNoteForm.errors = [];
                    this.createNoteForm.name = undefined;
                    this.createNoteForm.isCreated = true;
                    this.loadNotes();
                })
                .catch(error => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.createNoteForm.errors = _.flatten(
                            _.toArray(error.response.data.errors)
                        );
                    } else {
                        //TODO: update with your logic on how to handle this error.
                        console.log(error.message);
                        this.error =
                            "Unable to add note. View log for more information";
                    }
                })
                .finally(() => {
                    // disable loader
                    this.createNoteForm.isSubmitting = false;
                });
        },
        /**
         * Updates a NoteItem
         *
         */
        updateNote() {
            // update loader to loading
            this.editNoteForm.isSubmitting = true;
            // Use can use this as the payload.
            // const noteData = { name: this.createNoteForm.name };
            axios
                .put(`/notes/${this.editNoteForm.uuid}`, this.editNoteForm)
                .then(response => {
                    $("#editNoteItemModal").modal("hide");
                    this.editNoteForm.name = undefined;
                    this.editNoteForm.uuid = undefined;
                    this.editNoteForm.isUpdated = true;
                    this.loadNotes();
                })
                .catch(error => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.editNoteForm.errors = _.flatten(
                            _.toArray(error.response.data.errors)
                        );
                    } else {
                        //TODO: update with your logic on how to handle this error.
                        console.log(error.message);
                        this.error =
                            "Unable to update note. View log for more information";
                    }
                })
                .finally(() => {
                    // disable loader
                    this.editNoteForm.isSubmitting = false;
                });
        },
        /**
         * Deletes a NoteItem
         * @param noteItem
         */
        destroy(noteItem) {
            // Use can use this as the payload.
            // const noteData = { name: this.createNoteForm.name };
            axios
                .delete(`/notes/${noteItem.uuid}`)
                .then(response => {
                    this.loadNotes();
                })
                .catch(error => {
                    //TODO: update with your logic on how to handle this error.
                    console.log(error.message);
                    this.error =
                        "Unable to delete note. View log for more information";
                });
        }
    }
};
</script>
