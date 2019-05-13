<template>
    <div style="margin-bottom: 50px">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title"><i class="fas fa-plus-circle"></i> Refill the balance</div>
        </div>

        <div v-if="!wait">
            <form @submit="refill">
                <div class="popup__form-row">
                    <label class="popup__form-label">
                        <span class="_big">The amount of replenishment:</span>
                    </label>
                    <money v-model="amount" class="popup__form-input popup__form-input--big"></money>
                </div>

                <div class="popup__form" style="margin-bottom: 30px;" v-if="amount >= 0.01 && amount <= 100000.00">
                    <div class="popup__container--small">
                        <div class="popup__form-action w245">
                            <button class="btn btn-purple w100 btn-big" type="submit">
                                <span v-if="!wait">Refill</span>
                                <i v-else class="fas fa-spinner fa-spin"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div v-else>
            <img src="spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
                wait: false,
                amount: 0.00
            }
        },
        methods: {
            refill (e) {
                this.wait = true
                e.preventDefault()
                this.axios.post('payment', {amount: this.amount}).then((response) => {
                    if(response.data.redirect_url != undefined && /\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/.test(response.data.redirect_url)){
                        location = response.data.redirect_url;
                        //this.wait = false
                        toastr.success('Expect redirection to the payment system!')
                    }else{
                        toastr.error('Error payment response!')
                        this.wait = false
                    }
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    this.wait = false
                })
            }
        },
        mounted () {
            this.user = user
        }
    }
</script>