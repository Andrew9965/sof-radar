<template>
    <div style="margin-bottom: 50px">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title"><i class="far fa-comments"></i> Reviews <span v-if="items.total!=undefined && items.data.length">({{items.total}})</span></div>
        </div>

        <div v-if="!wait">
            <span v-if="items.data.length">
                <div class="review-item review-item--m_b" v-for="(item, index) in items.data">
                    <div class="review-item__inner">
                        <div class="review-item__header">

                            <div class="review-item__header-company" v-if="item.product">
                                <div class="_logo"><a :href="`/app/${item.product.slug}`"><img :src="item.product.logo" alt="" width="53"></a></div>
                                <div class="_info">
                                    <div class="_title"><a :href="`/app/${item.product.slug}`">{{item.product.title}}</a></div>
                                </div>
                            </div>

                            <div class="review-item__header-quote hidden-xs">«{{item.headline}}»</div>

                            <div v-if="false" class="review-item__header-rating">
                                <div class="rating">
                                    <div class="rating__inner">
                                        <div class="rating__info">
                                            <div class="rating__label ">Average rating:</div>

                                            <div class="rating__star ">
                                                <div class="rating-star ">
                                                    <div class="rating-star__inner">
                                                        <div class="rating-star__empty"></div>
                                                        <div class="rating-star__fill" :style="`width: ${(100/5)*calcRaitTotal(item)}%`"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="rating__total">
                                            <div :class="`rating-total__value ${item.color}`">
                                                <span class="_label">{{splitTotal(item)[0]}}</span>
                                                <span v-if="splitTotal(item)[1]!=undefined">{{splitTotal(item)[1]}}</span>/5
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="_action hidden-md hidden-sm"><a class="_btn js-review-rating-open">Details</a></div>

                            </div>
                        </div>

                        <div class="review-item__main  review-item__main--details">

                            <div class="review-item__main-rating" style="padding: 0;">

                                <div class="rating-all">
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Easy-of-use:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" :style="`width: ${(100/5)*item.easy_of_use}%`"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Functionality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" :style="`width: ${(100/5)*item.functionality}%`"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Product Quality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" :style="`width: ${(100/5)*item.product_quality}%`"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Customer Support:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" :style="`width: ${(100/5)*item.customer_support}%`"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Value for Money:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" :style="`width: ${(100/5)*item.value_for_money}%`"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="review-item__main-action">
                                <button class="_btn js-review-rating-close">Close</button>
                            </div>
                        </div>

                        <div class="review-item__body">

                            <div class="_inner">
                                <div class="review-item__header-quote hidden-md hidden-sm"><a href="#">«{{item.headline}}»</a></div>
                                <div class="_item">
                                    <div class="_label text-green">Like best:</div>
                                    <div class="_desc">{{item.like_best}}</div>
                                </div>

                                <div class="_item">
                                    <div class="_label text-red">Like least:</div>
                                    <div class="_desc">{{item.like_least}}</div>
                                </div>

                                <div class="_item">
                                    <div class="_label">Comments:</div>
                                    <div class="_desc">{{item.comment}}</div>
                                </div>

                                <div class="_action">
                                    <a class="_btn btn btn-purple btn-big-w" @click="editDialog(index)">Edit</a>
                                </div>
                            </div>
                        </div>

                        <div class="review-item__footer">
                            <div class="_time">
                                {{item.created_at}}
                            </div>
                        </div>
                    </div>

                </div>
            </span>

            <div v-else style="text-align: center;margin: 30px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 20vh;"></i>
                <h1>No reviews available.</h1>
            </div>
        </div>

        <div v-else>
            <img src="spinner.gif" style="margin: 0 auto; display: flex;"/>
        </div>

        <div v-if="items.last_page!=undefined && items.last_page!=1">
            <div class="pagination" style="margin-top: 50px">
                <div class="pagination__inner">


                    <a class="_item all" @click="getData(1)" style="cursor: pointer" v-if="items.current_page!=1 && items.current_page!=2">1</a>
                    <span class="_item dots" v-if="items.current_page!=1 && items.current_page!=2">...</span>


                    <a v-if="items.prev_page_url" @click="getData(items.current_page-1)" style="cursor: pointer" class="_item arrow arrow-left"><i></i></a>
                    <div class="_item current">{{items.current_page}}</div>
                    <a v-if="items.current_page!=items.last_page" @click="getData(items.current_page+1)" style="cursor: pointer" class="_item arrow arrow-right"><i></i></a>

                    <span class="_item dots" v-if="items.current_page != items.last_page">...</span>
                    <a class="_item all" @click="getData(items.last_page)" style="cursor: pointer" v-if="items.current_page != items.last_page">{{items.last_page}}</a>
                </div>
            </div>
        </div>

        <div class="popup" id="editReview">
                <div class="popup-inner">

                <form @submit.prevent="submitReview" class="submit_review" v-if="edit">
                    <a href="#" class="popup-close js-close-wnd"></a>
                    <div class="popup__title">
                        <span id="popup_title_1" class="popup_titles_my">
                            <div class="_text">Edit your review about</div>
                            <div class="_title">{{ edit.comment }}</div>
                            <div class="_label"><sup>*</sup> required fields</div>
                        </span>
                    </div>
                    <div class="popup__rating">
                        <div class="popup__rating-title">
                            <span> Rate this software from</span>
                            <i class="fill"></i>
                            <span>(bad) to</span>
                            <i class="fill"></i>
                            <i class="fill"></i>
                            <i class="fill"></i>
                            <i class="fill"></i>
                            <i class="fill"></i>
                            <span>great</span>
                        </div>
                        <div class="popup__rating-inner">
                            <div class="rating-all">
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Easy-of-use:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star ">
                                                        <span v-for="i in 5" @click="edit.easy_of_use = i">
                                                            <i :class="`${(edit.easy_of_use == 0 ? 1 : edit.easy_of_use) >= i ? 'fill' : ''}`"></i>
                                                        </span>
                                                    </div>

                                                    <div class="rating__value">{{edit.easy_of_use}}/5</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Functionality:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star ">
                                                        <span v-for="i in 5" @click="edit.functionality = i">
                                                            <i :class="`${(edit.functionality == 0 ? 1 : edit.functionality) >= i ? 'fill' : ''}`"></i>
                                                        </span>
                                                    </div>

                                                    <div class="rating__value">{{edit.functionality}}/5</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Product Quality:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star ">
                                                        <span v-for="i in 5" @click="edit.product_quality = i">
                                                            <i :class="`${(edit.product_quality == 0 ? 1 : edit.product_quality) >= i ? 'fill' : ''}`"></i>
                                                        </span>
                                                    </div>

                                                    <div class="rating__value">{{edit.product_quality}}/5</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Customer Support:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star ">
                                                        <span v-for="i in 5" @click="edit.customer_support = i">
                                                            <i :class="`${(edit.customer_support == 0 ? 1 : edit.customer_support) >= i ? 'fill' : ''}`"></i>
                                                        </span>
                                                    </div>

                                                    <div class="rating__value">{{edit.customer_support}}/5</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Value for Money:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star">
                                                        <span v-for="i in 5" @click="edit.value_for_money = i">
                                                            <i :class="`${(edit.value_for_money == 0 ? 1 : edit.value_for_money) >= i ? 'fill' : ''}`"></i>
                                                        </span>
                                                    </div>

                                                    <div class="rating__value">{{edit.value_for_money}}/5</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="popup__form">
                        <div class="popup__form-title">
                            <div class="_title">Your review</div>
                        </div>
                        <div :class="`popup__form-row ${!rules.headline() ? 'error' : 'success'}`">
                            <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.headline() ? '237, 59, 89' : '67, 187, 118'});`">Headline:</span></label>
                            <input type="text" v-model="edit.headline" class="popup__form-input popup__form-input--big counter" placeholder="Describe your experience in a few words">
                            <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.headline() ? '237, 59, 89' : '67, 187, 118'});`">(1 - 200 character)</span></div>
                            <div class="popup__form-symbol"><span>{{edit.headline.length}}</span>/200</div>
                        </div>

                        <div :class="`popup__form-row ${!rules.like_best() ? 'error' : 'success'}`">
                            <label class="popup__form-label required"><span :style="`color: rgb(${!rules.like_best() ? '237, 59, 89' : '67, 187, 118'});`">Like best:</span></label>
                            <textarea class="popup__form-area counter" v-model="edit.like_best" placeholder="What do you like most about this software."></textarea>
                            <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.like_best() ? '237, 59, 89' : '67, 187, 118'});`">(100 - 1500 character)</span></div>
                            <div class="popup__form-symbol"><span>{{edit.like_best.length}}</span>/1500</div>
                        </div>

                        <div :class="`popup__form-row ${!rules.like_least() ? 'error' : 'success'}`">
                            <label class="popup__form-label required"><span :style="`color: rgb(${!rules.like_least() ? '237, 59, 89' : '67, 187, 118'});`">Like least:</span></label>
                            <textarea class="popup__form-area counter" v-model="edit.like_least" placeholder="What do you like most about this software."></textarea>
                            <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.like_least() ? '237, 59, 89' : '67, 187, 118'});`">(100 - 1500 character)</span></div>
                            <div class="popup__form-symbol"><span>{{edit.like_least.length}}</span>/1500</div>
                        </div>

                        <div :class="`popup__form-row ${!rules.comment() ? 'error' : 'success'}`">
                            <label class="popup__form-label required"><span :style="`color: rgb(${!rules.comment() ? '237, 59, 89' : '67, 187, 118'});`">Comment:</span></label>
                            <textarea class="popup__form-area counter" v-model="edit.comment" placeholder="Summarize about your experience in using this software"></textarea>
                            <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.comment() ? '237, 59, 89' : '67, 187, 118'});`">(100 - 1500 character)</span></div>
                            <div class="popup__form-symbol"><span>{{edit.comment.length}}</span>/1500</div>
                        </div>

                        <div class="popup__form-row">
                            <label class="popup__form-label required"><span class="_small" style="color: #434262">How long do you use this software</span></label>
                            <div class="popup__form-select w245">
                                <select v-model="edit.used">
                                    <option :selected="edit.used == 'Less than 6 month'">Less than 6 month</option>
                                    <option :selected="edit.used == 'Less than 12 month'">Less than 12 month</option>
                                    <option :selected="edit.used == 'Less than 18 month'">Less than 18 month</option>
                                    <option :selected="edit.used == 'Less than 24 month'">Less than 24 month</option>
                                    <option :selected="edit.used == 'Less than 30 month'">Less than 30 month</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="popup__form" v-if="rules.comment() && rules.like_least() && rules.like_best() && rules.headline()">
                        <div class="popup__container--small">
                            <div class="popup__form-action w245">
                                <button class="btn btn-purple w100 btn-big" type="submit"
                                    :disabled="!rules.comment() || !rules.like_least() || !rules.like_best() || !rules.headline()"
                                >   <span v-if="!wait">Submit Review</span>
                                    <i v-else class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: [],
                items: { data: [], current_page: 0 },
                wait: true,
                edit: false,
                rules: {
                    comment: () => String(this.edit.comment).length < 100 || String(this.edit.comment).length > 1500 ? false : true,
                    like_least: () => String(this.edit.like_least).length < 100 || String(this.edit.like_least).length > 1500 ? false : true,
                    like_best: () => String(this.edit.like_best).length < 100 || String(this.edit.like_best).length > 1500 ? false : true,
                    headline: () => String(this.edit.headline).length < 1 || String(this.edit.headline).length > 200 ? false : true
                }
            }
        },
        watch: {
            edit ($data) {

            }
        },
        methods: {
            calcRaitTotal (item) {
                return (Number(item.easy_of_use)+Number(item.functionality)+Number(item.product_quality)+Number(item.customer_support)+Number(item.value_for_money))/5;
            },
            splitTotal (item) {
                return String(this.calcRaitTotal(item)).split('.')
            },
            getData ($page = 1) {
                this.wait = true
                this.axios.post('get_reviews', {page: $page}).then((responce) => {
                    this.items = responce.data
                    console.log(this.items.data.length)
                    this.wait = false
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    this.wait = false
                })
            },
            currentPage: (p) => {

            },
            editDialog ($index) {
                this.edit = this.items.data[$index]
                Popups.openById('editReview')
                Popups.showOverlay()
            },
            submitReview (e) {
                if(!this.rules.comment() || !this.rules.like_least() || !this.rules.like_best() || !this.rules.headline()) return toastr.error('Error validation!')
                if(!this.edit) return toastr.error('Error!')
                this.wait = true
                this.axios.post('save_review', this.edit).then((responce) => {
                    this.getData(this.items.current_page)
                    this.edit = false
                    this.wait = false
                    Popups.hide()
                    toastr.success('Saved!')
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    this.wait = false
                })
                e.preventDefault()
            }
        },
        mounted () {
            this.user = user
            this.getData()
        }
    }
</script>