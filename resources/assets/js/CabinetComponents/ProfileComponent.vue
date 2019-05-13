<template>
    <form @submit="submit">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title"><i class="far fa-user"></i> Profile</div>
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label">
                <span class="_big">E-Mail:</span>
            </label>
            <input type="text" name="email" disabled :value="user.email" class="popup__form-input popup__form-input--big">
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label required">
                <span class="_big" style="color: #7440b3">Name:</span>
            </label>
            <input type="text" name="name" v-model="user.name" class="popup__form-input popup__form-input--big" placeholder="Enter you name">
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label">
                <span class="_big" style="color: #7440b3">Position:</span>
            </label>
            <input type="text" name="position" v-model="user.position" class="popup__form-input popup__form-input--big" placeholder="Enter you position">
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label">
                <span class="_big">Created at:</span>
            </label>
            <input type="text" name="created_at" disabled :value="user.created_at" class="popup__form-input popup__form-input--big">
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label">
                <span class="_big">Updated at:</span>
            </label>
            <input type="text" name="updated_at" disabled :value="user.updated_at" class="popup__form-input popup__form-input--big">
        </div>

        <div class="popup__form" style="margin-bottom: 30px;">
            <div class="popup__container--small">
                <div class="popup__form-action w245">
                    <button class="btn btn-purple w100 btn-big" type="submit">
                        <span v-if="!wait">Save profile</span>
                        <i v-else class="fas fa-spinner fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
                wait: false
            }
        },
        watch: {},
        methods: {
            submit (e) {
                this.wait = true
                e.preventDefault()
                this.axios.post('save_profile', this.user).then((responce) => {
                    if (responce.data.status == 'success')
                        toastr.success(responce.data.message)
                    else
                        toastr.error(responce.data.message)

                    this.wait = false
                }).catch((err) => {
                    toastr.error(err.message)
                    this.wait = false
                })
            }
        },
        mounted () {
            this.user = user
        }
    }
</script>