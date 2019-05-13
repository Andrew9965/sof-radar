export default {
    install(Vue, options) {
        Vue.mixin({
            data: function () {
                return {
                    errors: {},
                    waiter: false,
                }
            },
            methods: {
                $wait ($state='get') { if ($state=='get') return this.waiter; else { return this.waiter = !this.waiter } },
                $errorSet ($data={}) { this.errors = $data },
                $error ($name=false) { if(this.errors == undefined) return false; if($name=='all-keys') return this.errors; let $return = this.errors[$name] == undefined ? false : this.errors[$name]; return $return;},
                $post (url, params={}, cb, cbError) {this.$errorSet(); return window.axios.post(url, params).then((response) => this.$eventAxiosSuccess(response, cb, cbError)).catch((err) => this.$eventAxiosError(err, cbError));},
                $get (url, params={}, cb, cbError) {this.$errorSet(); return window.axios.get(url, {params}).then((response) => this.$eventAxiosSuccess(response, cb, cbError)).catch((err) => this.$eventAxiosError(err, cbError));},
                $eventAxiosError (err, cb) {
                    if(err.response != undefined && err.response.data != undefined && err.response.data.errors != undefined && typeof err.response.data.errors == 'object') this.$errorSet(err.response.data.errors);
                    toastr.error(err.response != undefined && err.response.data.message ? err.response.data.message : err.message); if(cb && typeof cb =='function') cb(err)
                },
                $eventAxiosSuccess (response, cb, cbError) {
                    let data = response.data
                    return new Promise((resolve, reject) => {
                        if(data.status == undefined) reject({message: 'Undefined status!'});
                        if(data.status == 'success' && cb && typeof cb == 'function') cb(response);
                        else if(data.status == 'error') this.$eventAxiosError(data, cbError)
                        else reject({message: 'Unknown status!'});
                    }).catch((err) => this.$eventAxiosError(err, cbError));
                }
            }
        })

        // Vue.prototype.
    }
}