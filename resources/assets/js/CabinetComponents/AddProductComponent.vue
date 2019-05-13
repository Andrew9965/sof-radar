<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div style="margin-bottom: 50px">
        <div class="filter__header" style="margin-bottom: 30px">
            <div class="_title" v-if="this.$route.params.slug && edit.title != ''"><i class="fas fa-edit"></i> Edit product "{{ edit.title }}"</div>
            <div class="_title" v-else><i class="fas fa-plus-square"></i> Add product</div>
        </div>

        <div v-if="!wait">
            <form @submit="submit">

                <div :class="`popup__form-row ${!rules.title() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.title() ? '237, 59, 89' : '67, 187, 118'});`">Title:</span></label>
                    <input type="text" v-model="edit.title" class="popup__form-input popup__form-input--big counter">
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.title() ? '237, 59, 89' : '67, 187, 118'});`">(2 - 255 character)</span></div>
                    <div class="popup__form-symbol"><span>{{edit.title.length}}</span>/255</div>
                </div>

                <div :class="`popup__form-row ${!rules.company() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.company() ? '237, 59, 89' : '67, 187, 118'});`">Company:</span></label>
                    <input type="text" v-model="edit.company" class="popup__form-input popup__form-input--big counter">
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.company() ? '237, 59, 89' : '67, 187, 118'});`">(2 - 255 character)</span></div>
                    <div class="popup__form-symbol"><span>{{edit.company.length}}</span>/255</div>
                </div>

                <div :class="`popup__form-row ${!rules.web_site() ? 'error' : 'success'}`">
                    <label class="popup__form-label"><span class="_big" :style="`color: rgb(${!rules.web_site() ? '237, 59, 89' : '67, 187, 118'});`">WEB site</span></label>
                    <input type="text" v-model="edit.web_site" @change="webChange()" class="popup__form-input popup__form-input--big counter">
                </div>

                <div :class="`popup__form-row ${!rules.logo() ? 'error' : 'success'}`" @click="openUpload" style="cursor: pointer">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.logo() ? '237, 59, 89' : '67, 187, 118'});`">Logo:</span></label>
                    <input type="file" ref="file" v-on:change="uploadFile" id="uploadFile" style="display: none">
                    <div class="popup__form-input popup__form-input--big counter" style="text-align: right;height: auto;min-height: 56px;">
                        <span v-if="!wait && edit.logo"><img :src="edit.logo" style="max-height: 50px" /></span>
                        <button class="btn btn-purple btn-big" type="submit" style="float: left;margin-left: -11px;height: 54px;">
                            <span v-if="!waitBtn">Select...</span>
                            <i v-else class="fas fa-spinner fa-spin"></i>
                        </button>
                    </div>
                </div>

                <div :class="`popup__form-row ${!rules.category_1() ? 'error' : 'success'}`" v-if="show.category_1">
                    <label class="popup__form-label required">
                        <span class="_big" :style="`color: rgb(${!rules.category_1() ? '237, 59, 89' : '67, 187, 118'});`">
                            Category:
                        </span>
                    </label>
                    <div>
                        <select2 :options="categories" v-model="edit.category_1" classStyle="popup__form-input popup__form-input--big counter vue-select2-inputform" ajax="/api/get_categories"></select2>
                    </div>
                </div>

                <div class="page-ui_toolkit__section" v-if="Number(edit.category_1)!=0 && all_categories[edit.category_1]">
                    <div class="page-ui_toolkit__section_title" @click="edit.features[1].length ? show.ff_1=!show.ff_1 : show.ff_1=show.ff_1" style="cursor: pointer">
                        Functional features: {{all_categories[edit.category_1].title}}

                        <i v-if="edit.features[1].length" :class="`fas fa-angle-double-${show.ff_1 ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in all_categories[edit.category_1].categories_ff" v-if="show.ff_1 || !edit.features[1].length">
                        <input type="checkbox" class="_input" :id="`ff${item.id}`" v-model="edit.features[1]" :value="item.title" @click="show.ff_1=true">
                        <label :for="`ff${item.id}`" class="_label">{{item.title}}</label>
                    </div>
                    <div v-if="!show.ff_1 && edit.features[1].length" @click="show.ff_1=true">Selected ({{edit.features[1].length}})</div>
                </div>

                <div :class="`popup__form-row ${!rules.category_2() ? 'error' : 'success'}`" v-if="show.category_2 || (Number(edit.category_2)!=0)">
                    <label class="popup__form-label">
                        <i class="fas fa-trash-alt" @click="!show.category_3 ? edit.category_2 = 0 : edit.category_3 = 0; !show.category_3 ? edit.features[2] = [] : edit.features[3] = []; !show.category_3 ? show.category_2 = false : show.category_3 = false" style="cursor: pointer"></i>
                        <span class="_big" :style="`color: rgb(${!rules.category_2() ? '237, 59, 89' : '67, 187, 118'});`">
                            Second category:
                        </span>
                    </label>
                    <div>
                        <select2 :options="categories" v-model="edit.category_2" classStyle="popup__form-input popup__form-input--big counter vue-select2-inputform" ajax="/api/get_categories"></select2>
                    </div>
                </div>
                <!--<a @click="test">123</a>-->
                <div class="page-ui_toolkit__section" v-if="Number(edit.category_2)!=0 && all_categories[edit.category_2]">
                    <div class="page-ui_toolkit__section_title" @click="edit.features[2].length ? show.ff_2=!show.ff_2 : show.ff_2=show.ff_2" style="cursor: pointer">
                        Functional features: {{all_categories[edit.category_2].title}}

                        <i v-if="edit.features[2].length" :class="`fas fa-angle-double-${show.ff_2 ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in all_categories[edit.category_2].categories_ff" v-if="show.ff_2 || !edit.features[2].length">
                        <input type="checkbox" class="_input" :id="`ff2${item.id}`" v-model="edit.features[2]" :value="item.title" @click="show.ff_2=true">
                        <label :for="`ff2${item.id}`" class="_label">{{item.title}}</label>
                    </div>
                    <div v-if="!show.ff_2 && edit.features[2].length" @click="show.ff_2=true">Selected ({{edit.features[2].length}})</div>
                </div>

                <div :class="`popup__form-row ${!rules.category_3() ? 'error' : 'success'}`" v-if="show.category_3 || (edit.category_3 !=0 && edit.category_3 != '0')">
                    <label class="popup__form-label">
                        <i class="fas fa-trash-alt" @click="show.category_3 = false; edit.category_3 = 0; edit.features[3] = []" style="cursor: pointer"></i>
                        <span class="_big" :style="`color: rgb(${!rules.category_3() ? '237, 59, 89' : '67, 187, 118'});`">
                            Third category:
                        </span>
                    </label>
                    <div>
                        <select2 :options="categories" v-model="edit.category_3" classStyle="popup__form-input popup__form-input--big counter vue-select2-inputform" ajax="/api/get_categories"></select2>
                    </div>
                </div>

                <div class="page-ui_toolkit__section" v-if="Number(edit.category_3)!=0 && all_categories[edit.category_3]">
                    <div class="page-ui_toolkit__section_title" @click="edit.features[3].length ? show.ff_3=!show.ff_3 : show.ff_3=show.ff_3" style="cursor: pointer">
                        Functional features: {{all_categories[edit.category_3].title}}

                        <i v-if="edit.features[3].length" :class="`fas fa-angle-double-${show.ff_3 ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in all_categories[edit.category_3].categories_ff" v-if="show.ff_3 || !edit.features[3].length">
                        <input type="checkbox" class="_input" :id="`ff3${item.id}`" v-model="edit.features[3]" :value="item.title" @click="show.ff_3=true">
                        <label :for="`ff3${item.id}`" class="_label">{{item.title}}</label>
                    </div>
                    <div v-if="!show.ff_3 && edit.features[3].length" @click="show.ff_3=true">Selected ({{edit.features[3].length}})</div>
                </div>

                <button class="btn btn-purple w100 btn-big" type="button" v-if="!show.category_1 || (!show.category_2 || (edit.category_2 !=0 && edit.category_2 != '0')) || (!show.category_3 || (edit.category_3 !=0 && edit.category_3 != '0'))" @click="addCat()" style="margin-bottom: 50px">
                    <span>Add category</span>
                </button>

                <div :class="`popup__form-row ${!rules.short_description() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.short_description() ? '237, 59, 89' : '67, 187, 118'});`">Short description:</span></label>
                    <vue-editor type="text" v-model="edit.short_description"></vue-editor>
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.short_description() ? '237, 59, 89' : '67, 187, 118'});`">(100 - 2500 character)</span></div>
                    <div class="popup__form-symbol"><span>{{edit.short_description.length}}</span>/2500</div>
                </div>

                <div :class="`popup__form-row ${!rules.fool_description() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.fool_description() ? '237, 59, 89' : '67, 187, 118'});`">Full description:</span></label>
                    <vue-editor type="text" v-model="edit.fool_description"></vue-editor>
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.fool_description() ? '237, 59, 89' : '67, 187, 118'});`">(100 - 2500 character)</span></div>
                    <div class="popup__form-symbol"><span>{{edit.fool_description.length}}</span>/2500</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.details.deployment.length ? show.deployment=!show.deployment : show.deployment=show.deployment" style="cursor: pointer">
                        Deployment
                        <i v-if="edit.details.deployment.length" :class="`fas fa-angle-double-${show.deployment ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['SaaS', 'InHouse']" v-if="show.deployment || !edit.details.deployment.length">
                        <input type="checkbox" class="_input" :id="`deployment${index}`" v-model="edit.details.deployment" :value="item" @click="show.deployment=true">
                        <label :for="`deployment${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.deployment && edit.details.deployment.length" @click="show.deployment=true">Selected ({{edit.details.deployment.length}})</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.details.desc_client.length ? show.desc_client=!show.desc_client : show.desc_client=show.desc_client" style="cursor: pointer">
                        Desktop client
                        <i v-if="edit.details.desc_client.length" :class="`fas fa-angle-double-${show.desc_client ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['Windows', 'Linux', 'Mac', 'Web-browser']" v-if="show.desc_client || !edit.details.desc_client.length">
                        <input type="checkbox" class="_input" :id="`desc_client${index}`" v-model="edit.details.desc_client" :value="item" @click="show.desc_client=true">
                        <label :for="`desc_client${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.desc_client && edit.details.desc_client.length" @click="show.desc_client=true">Selected ({{edit.details.desc_client.length}})</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.details.mobile_version.length ? show.mobile_version=!show.mobile_version : show.mobile_version=show.mobile_version" style="cursor: pointer">
                        Mobile version
                        <i v-if="edit.details.mobile_version.length" :class="`fas fa-angle-double-${show.mobile_version ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['Android', 'IOS', 'Windows phone', 'Web-browser']" v-if="show.mobile_version || !edit.details.mobile_version.length">
                        <input type="checkbox" class="_input" :id="`mobile_version${index}`" v-model="edit.details.mobile_version" :value="item" @click="show.mobile_version=true">
                        <label :for="`mobile_version${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.mobile_version && edit.details.mobile_version.length" @click="show.mobile_version=true">Selected ({{edit.details.mobile_version.length}})</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.details.business_size.length ? show.business_size=!show.business_size : show.business_size=show.business_size" style="cursor: pointer">
                        Business size
                        <i v-if="edit.details.business_size.length" :class="`fas fa-angle-double-${show.business_size ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['Small', 'Medium', 'Enterprise']" v-if="show.business_size || !edit.details.business_size.length">
                        <input type="checkbox" class="_input" :id="`business_size${index}`" v-model="edit.details.business_size" :value="item" @click="show.business_size=true">
                        <label :for="`business_size${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.business_size && edit.details.business_size.length" @click="show.business_size=true">Selected ({{edit.details.business_size.length}})</div>
                </div>

                <div :class="`popup__form-row ${!rules.vendor_detalis() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.vendor_detalis() ? '237, 59, 89' : '67, 187, 118'});`">Vendor Details:</span></label>
                    <vue-editor type="text" v-model="edit.details.vendor_detalis"></vue-editor>
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.vendor_detalis() ? '237, 59, 89' : '67, 187, 118'});`">(max 2500 character)</span></div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title">
                        Starting price
                        <toggle-button :width="90" :value="edit.pricing.starting_price.onsubmit == 'on'" color="#7440b3" :sync="true" :labels="{checked: 'OnSubmit', unchecked: 'NoSubmit'}" @change="toggler('edit.pricing.starting_price.onsubmit')"/>
                    </div>

                    <div :class="`popup__form-row ${!rules.starting_price_price() ? 'error' : 'success'}`" v-if="edit.pricing.starting_price.onsubmit != 'on'">
                        <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.starting_price_price() ? '237, 59, 89' : '67, 187, 118'});`">Price:</span></label>
                        <money v-model="edit.pricing.starting_price.price" class="popup__form-input popup__form-input--big"></money>
                    </div>

                    <div :class="`popup__form-row ${!rules.starting_price_link() ? 'error' : 'success'}`" v-if="edit.pricing.starting_price.onsubmit == 'on'">
                        <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.starting_price_link() ? '237, 59, 89' : '67, 187, 118'});`">Link:</span></label>
                        <input type="text" v-model="edit.pricing.starting_price.link" class="popup__form-input popup__form-input--big">
                    </div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.pricing.pricing_model.length ? show.pricing_model=!show.pricing_model : show.pricing_model=show.pricing_model" style="cursor: pointer">
                        Pricing model
                        <i v-if="edit.pricing.pricing_model.length" :class="`fas fa-angle-double-${show.pricing_model ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['Freemium', 'Subscription', 'One-time license', 'Open-source']" v-if="show.pricing_model || !edit.pricing.pricing_model.length">
                        <input type="checkbox" class="_input" :id="`pricing_model${index}`" v-model="edit.pricing.pricing_model" :value="item" @click="show.pricing_model=true">
                        <label :for="`pricing_model${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.pricing_model && edit.pricing.pricing_model.length" @click="show.pricing_model=true">Selected ({{edit.pricing.pricing_model.length}})</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title" @click="edit.pricing.training.length ? show.training=!show.training : show.training=show.training" style="cursor: pointer">
                        Training
                        <i v-if="edit.pricing.training.length" :class="`fas fa-angle-double-${show.training ? 'up' : 'down'}`" style="position: absolute;right: 30px"></i>
                    </div>
                    <div class="checkbox-container" v-for="(item, index) in ['Documenation', 'Webinars', 'In person', 'Live courses']" v-if="show.training || !edit.pricing.training.length">
                        <input type="checkbox" class="_input" :id="`training${index}`" v-model="edit.pricing.training" :value="item" @click="show.training=true">
                        <label :for="`training${index}`" class="_label">{{item}}</label>
                    </div>
                    <div v-if="!show.training && edit.pricing.training.length" @click="show.training=true">Selected ({{edit.pricing.training.length}})</div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title">
                        License price
                        <toggle-button :width="90" :value="edit.pricing.license_price.onsubmit == 'on'" color="#7440b3" :sync="true" :labels="{checked: 'OnSubmit', unchecked: 'NoSubmit'}" @change="toggler('edit.pricing.license_price.onsubmit')"/>
                    </div>

                    <div :class="`popup__form-row ${!rules.license_price_price() ? 'error' : 'success'}`" v-if="edit.pricing.license_price.onsubmit != 'on'">
                        <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.license_price_price() ? '237, 59, 89' : '67, 187, 118'});`">Price:</span></label>
                        <money v-model="edit.pricing.license_price.price" class="popup__form-input popup__form-input--big"></money>
                    </div>

                    <div :class="`popup__form-row ${!rules.license_price_link() ? 'error' : 'success'}`" v-if="edit.pricing.license_price.onsubmit == 'on'">
                        <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.license_price_link() ? '237, 59, 89' : '67, 187, 118'});`">Link:</span></label>
                        <input type="text" v-model="edit.pricing.license_price.link" class="popup__form-input popup__form-input--big">
                    </div>
                </div>

                <div class="page-ui_toolkit__section">
                    <div class="page-ui_toolkit__section_title">
                        Free trial
                        <toggle-button :width="90" :value="edit.pricing.free_trial.active == 'on'" color="#7440b3" :sync="true" :labels="{checked: 'Enabled', unchecked: 'Disabled'}" @change="toggler('edit.pricing.free_trial.active')"/>
                    </div>
                    <span v-if="edit.pricing.free_trial.active == 'on'">
                        <div :class="`popup__form-row ${!rules.free_trial_link() ? 'error' : 'success'}`" v-if="edit.pricing.free_trial.button == 'on'">
                        <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.free_trial_link() ? '237, 59, 89' : '67, 187, 118'});`">Link:</span></label>
                        <input type="text" v-model="edit.pricing.free_trial.link" class="popup__form-input popup__form-input--big">
                    </div>
                    <toggle-button :width="90" :value="edit.pricing.free_trial.button == 'on'" color="#7440b3" :sync="true" :labels="{checked: 'Button on', unchecked: 'Button off'}" @change="toggler('edit.pricing.free_trial.button')"/>
                    </span>
                </div>

                <div :class="`popup__form-row ${!rules.pricing_desc() ? 'error' : 'success'}`">
                    <label class="popup__form-label required"><span class="_big" :style="`color: rgb(${!rules.pricing_desc() ? '237, 59, 89' : '67, 187, 118'});`">Pricing description:</span></label>
                    <vue-editor type="text" v-model="edit.pricing_desc"></vue-editor>
                    <div class="popup__form-symbol" style="left: 0;"><span :style="`color: rgb(${!rules.pricing_desc() ? '237, 59, 89' : '67, 187, 118'});`">(max 2500 character)</span></div>
                    <div class="popup__form-symbol"><span>{{edit.pricing_desc.length}}</span>/2500</div>
                </div>

                <div class="popup__form" v-if="valid()">
                    <div class="popup__container--small">
                        <div class="popup__form-action w245">
                            <button class="btn btn-purple w100 btn-big" type="submit">
                                <span v-if="!wait">Save</span>
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
    import { VueEditor } from 'vue2-editor'
    import _ from 'lodash'

    export default {
        components: {
            VueEditor
        },
        data () {
            return {
                show: {
                    training: false,
                    pricing_model: false,
                    business_size: false,
                    mobile_version: false,
                    desc_client: false,
                    deployment: false,
                    ff_1: false,
                    ff_2: false,
                    ff_3: false,
                    category_1: true,
                    category_2: false,
                    category_3: false
                },
                user: [],
                categories: [],
                all_categories: [],
                edit: {
                    title: '',
                    company: '',
                    web_site: '',
                    logo: '',
                    short_description: '',
                    fool_description: '',
                    categories: [],
                    category_1: 0,
                    category_2: 0,
                    category_3: 0,
                    features: {1:[], 2:[], 3:[]},
                    details: {
                        deployment: [],
                        desc_client: [],
                        mobile_version: [],
                        business_size: [],
                        vendor_detalis: ''
                    },
                    pricing: {
                        starting_price: {price: '0.00', link: '', onsubmit: 'off'},
                        license_price: {price: '0.00', link: '', onsubmit: 'off'},
                        free_trial: {active: 'off', link: '', button: 'off'},
                        pricing_model: [],
                        training: []
                    },
                    pricing_desc: ''
                },
                rules: {
                    title: () => String(this.edit.title).length < 2 || String(this.edit.title).length > 255 ? false : true,
                    company: () => String(this.edit.company).length < 2 || String(this.edit.company).length > 255 ? false : true,
                    web_site: () => this.edit.web_site != '' && this.edit.web_site != null ? (/\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/.test(this.edit.web_site)) : true,
                    logo: () => String(this.edit.logo).length < 1 || String(this.edit.logo).length > 255 ? false : true,
                    short_description: () => String(this.edit.short_description).length < 100 || String(this.edit.short_description).length > 2500 ? false : true,
                    fool_description: () => String(this.edit.fool_description).length < 100 || String(this.edit.fool_description).length > 2500 ? false : true,
                    pricing_desc: () => String(this.edit.pricing_desc).length > 2500 ? false : true,
                    vendor_detalis: () => String(this.edit.details.vendor_detalis).length > 2500 ? false : true,
                    category_1: () => this.show.category_1 ? (Number(this.edit.category_1) < 1 ? false : true) : true,
                    category_2: () => this.show.category_2 ? (Number(this.edit.category_2) < 1 ? false : true) : true,
                    category_3: () => this.show.category_3 ? (Number(this.edit.category_3) < 1 ? false : true) : true,
                    starting_price_link: () => this.edit.pricing.starting_price.onsubmit == 'on' ? (/\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/.test(this.edit.pricing.starting_price.link)) : true,
                    starting_price_price: () => this.edit.pricing.starting_price.onsubmit == 'off' ? (this.edit.pricing.starting_price.price > 0) : true,
                    license_price_link: () => this.edit.pricing.license_price.onsubmit == 'on' ? (/\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/.test(this.edit.pricing.license_price.link)) : true,
                    license_price_price: () => this.edit.pricing.license_price.onsubmit == 'off' ? (this.edit.pricing.license_price.price > 0) : true,
                    free_trial_link: () => this.edit.pricing.free_trial.active == 'on' && this.edit.pricing.free_trial.button == 'on' ? (/\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/.test(this.edit.pricing.free_trial.link)) : true,
                },
                wait: true,
                waitBtn: false,
            }
        },
        methods: {
            webChange () {
                if(this.edit.pricing.starting_price.link == '' && this.rules.web_site()) this.edit.pricing.starting_price.link = this.edit.web_site
                if(this.edit.pricing.license_price.link == '' && this.rules.web_site()) this.edit.pricing.license_price.link = this.edit.web_site
                if(this.edit.pricing.free_trial.link == '' && this.rules.web_site()) this.edit.pricing.free_trial.link = this.edit.web_site
            },
            cleanFF ($num, $newVal) {
                console.log('>>NV>>', $newVal)
                this.edit.features[$num] = []
            },
            addCat () {
                if (!this.show.category_2) {
                    this.show.category_2 = true
                }
                else if (!this.show.category_3) {
                    this.show.category_3 = true
                }
            },
            test () {
                console.log(this.edit)
            },
            submit (e) {
                if(this.valid()){
                    this.wait=true
                    this.axios.post('save_product', this.edit).then((response) => {
                        toastr[response.data.status](response.data.message)
                        this.wait=false
                    }).catch((err) => {
                        toastr.error(err.response.data.message ? err.response.data.message : err.message)
                        this.wait=false
                    })
                }
                console.log(this.edit)
                e.preventDefault()
            },
            valid () {
                let results = {}
                let $false = 0
                _.map(this.rules, (func, name) => {
                    results[name] = func()
                    if(!results[name]) $false++
                })
                return $false ? false : true
            },
            uploadFile (e) {
                this.formData = new FormData();
                this.formData.append('file', this.$refs.file.files[0]);
                this.waitBtn = true

                this.axios.post('file_uploader', this.formData, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        this.edit.logo = response.data
                        this.waitBtn = false
//                        toastr.success('File successfully upload!')
                    })
                    .catch(err => {
                        toastr.error(err.response.data.message ? err.response.data.message : err.message)
                    });
            },
            openUpload () {
                $('#uploadFile').trigger('click')
            },
            toggler ($map) {
                eval(`this.${$map} = this.${$map} == 'on' ? 'off' : 'on'`)
            }
        },
        mounted () {
            this.user = user
            if(this.$route.params.slug){
                this.axios.get('get_product', {params: {slug: this.$route.params.slug}}).then((response) => {
                    if(response.data.id!=undefined){
                        _.map(this.edit, (val, key) => {
                            if(response.data[key] != undefined) this.edit[key] = response.data[key]
//                            console.log('>>>>', key +' >>', response.data[key] != undefined, '>>', this.edit[key])
                        })
                        this.edit._id = response.data.id

                        if(this.edit.pricing.starting_price.price == null) this.edit.pricing.starting_price.price = 0
                        if(this.edit.pricing.license_price.price == null) this.edit.pricing.license_price.price = 0

                    }else{
                        toastr.error('Error!')
                    }
                    this.wait=false
                }).catch((err) => {
                    toastr.error(err.response.data.message ? err.response.data.message : err.message)
                })
            }

            this.axios.get('get_categories').then((response) => {
                this.categories = response.data.results
                this.all_categories = response.data.all
                if(!this.$route.params.slug) this.wait=false
            }).catch((err) => {
                toastr.error(err.response.data.message ? err.response.data.message : err.message)
            })
//            this.valid()
            // this.$route.params.slug
        }
    }
</script>