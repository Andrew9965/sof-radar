export default {
    install(Vue, options) {
        Vue.mixin({
            methods: {
                /**
                 * Get Translate by key
                 *
                 * @param param
                 * @param replace
                 * @returns {*}
                 */
                __ (param, replace = {}) { let $return = this.array_get(window.langs.lia_admin, param); Object.keys(replace).map(function(objectKey) {$return = $return.replace(':'+objectKey, replace[objectKey])}); return $return;},

                /**
                 * Get Lia registration config. If have.
                 *
                 * @param param
                 * @returns {*}
                 */
                reg_cfg (param) { return this.cfg('lia_registration', param); },

                /**
                 * Get Lia route config. If have.
                 *
                 * @param param
                 * @returns {*}
                 */
                route_cfg (param) { return this.cfg('lia_route', param); },

                /**
                 * Get Lia configs. If have.
                 *
                 * @param $var
                 * @param param
                 * @returns {*}
                 */
                cfg ($var, param) { return window.config != undefined && window.config[$var] != undefined ? this.array_get(window.config[$var], param) : param },

                /**
                 * Function Trim how in PHP
                 *
                 * @param str
                 * @param chars
                 * @returns {*}
                 */
                trim (str, chars=" ") {return this.ltrim(this.rtrim(str, chars), chars);},

                /**
                 * Function Left Trim how in PHP, only for left side.
                 *
                 * @param str
                 * @param chars
                 */
                ltrim (str, chars) { chars = chars || "\\s"; return str.replace(new RegExp("^[" + chars + "]+", "g"), "");},

                /**
                 * Function Right Trim how in PHP, only for right side.
                 *
                 * @param str
                 * @param chars
                 */
                rtrim (str, chars) { chars = chars || "\\s"; return str.replace(new RegExp("[" + chars + "]+$", "g"), "");},

                /**
                 * Get URL with LIA URL Prefix.
                 *
                 * @param $path
                 * @returns {string}
                 */
                route ($path) { return (this.route_cfg('prefix')!='' ? '/' : '')+this.trim(this.route_cfg('prefix'), '/')+'/'+this.trim($path, '/');},

                /**
                 *  replicates array_get feature from laravel
                 */
                array_get (i,k,d) {if (typeof d === 'undefined') { d = null; } if (!k) return i; let s = k.split('.'); let o = i; for(let x=0;x < s.length; x++) { if (null !== o && o.hasOwnProperty(s[x])) { o = o[s[x]]; } else { return d; }} return o;},

                /**
                 *  replicates array_set feature from laravel
                 */
                array_set(i,k,v) {if (!k) return; let s = k.split('.'); h = i; for(let x=0;x < s.length-1; x++){ if (h.hasOwnProperty(s[x])) h = h[s[x]]; else { for(let y = s.length-1;x <= y; y--) { w = v; v = {}; v[s[y]] = w; } h[s[x]] = v[s[x]]; return; } } h[s[x]] = v;},

                /**
                 *  replicates array_dot feature from laravel
                 */
                array_dot (i, p) {let o = {};p = p || ''; if (p) { p = p+'.'; } if (typeof i == 'object') { for (let k in i) { if (i.hasOwnProperty(k)) { if (typeof i[k] == 'object') { x = array_dot(i[k],k); for(let l in x) { o[p+l] = x[l]; } } else { o[p+k] = i[k]; } } } } return o;},

                /**
                 *  replicates array_dot feature from laravel
                 */
                array_flatten (i) { i = Object(i); let o = []; for(let k in i) { if (i.hasOwnProperty(k)) { if (typeof i[k]=='object') { o = o.concat(this.array_flatten(i[k])); } else { o.push(i[k]); } } } return o;},

                /**
                 *  replicates array_first feature from laravel
                 */
                array_first (a,f,d) { if (!f && a.length) return a[0]; for(let x = 0; x < a.length; x++) { if (f(a[x])) return a[x]; } return d;},

                /**
                 *  replicates array_except feature from laravel
                 *   (does not account for array_dot sub-keys)
                 */
                array_except(a,ks){ let b = jQuery.extend(true, {}, a); ks.forEach(function(k){ delete b[k]; }); return b; },

                /**
                 *  replicates array_only feature from laravel
                 *   (does not account for array_dot sub-keys)
                 */
                array_only(a,ks){ let b = jQuery.extend(true, {}, a); for(let k in a) { if (ks.indexOf(k) === -1) delete b[k]; } return b; },

                /**
                 * replicates array_fetch feature from laravel
                 */
                array_fetch (arr,key) { let r = []; for (let k in arr) { if (arr.hasOwnProperty(k)) { if (this.array_has(arr[k],key)) { r.push(this.array_get(arr[k],key)); } } } return r; },

                /**
                 *  This checks if a deeply nested variable is set, similar to Laravel's Input::has('key')
                 */
                array_has (arr,key) { return (this.array_get(arr,key,false)!==false && this.array_get(arr,key,true)!==true); },

                /**
                 * replicates array_last feature from laravel
                 *
                 * @param arr
                 * @returns {*}
                 */
                array_last (arr) { return arr.slice(-1)[0] },

                /**
                 * Sum all array elements (for Number Array)
                 *
                 * @param arr
                 * @returns {number}
                 */
                array_sum(arr, cb=false){ let k = 0; for(let i = 0; i <= (arr.length-1); i++) k += arr[i]; return 'function' == typeof cb ? cb(k) : k; },

                /**
                 * Get big element (for Number Array)
                 *
                 * @param arr
                 * @param cb
                 * @returns {number}
                 */
                array_big (arr, return_key=false) { let $value = 0; let $key = 0; for(let i = 0; i <= (arr.length-1); i++){ if(arr[i] >= $value) { $value = arr[i]; $key = i; } } return return_key ? $key : $value;}
            }
        })
    }
}

