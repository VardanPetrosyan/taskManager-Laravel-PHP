<template>

    <header title="">
        <div class="container no-padding" title="">
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Փոխել</h4>
                        </div>
                        <div class="modal-body row" style="text-align: center">
                            <form id="change-form">
                                <div class="col-xs-12 user-new-img" style="text-align: center">
                                    <label style="display: block">Նոր պատկեր</label>
                                    <label id="new-img-block">
                                        <i v-if="user && !user.img" class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <img id="user-new-image" v-if="user && user.img" v-bind:src="`${'assets/images/upload/'+user.img}`" style="width: 120px;"/>
                                        <img v-else :src="`${'assets/images/upload/Default_user_image.jpg'}`" style="width: 120px;"/>
                                        <input v-on:change="changeUserImg" type="file" id="new-img"/>
                                    </label>
                                </div>
                                <div class="col-xs-12">
                                    <label>Նոր անուն</label><br/>
                                    <input v-if="user" type="text" v-on:change="changeUserName" class="form-control" id="new-name" :placeholder="user.name" />
                                </div>
                                <div class="col-xs-12">
                                    <label>Ընթացիկ Գաղտնաբառ</label><br/>
                                    <input type="text" v-on:change="currentUserPassword" class="form-control" id="current-password" placeholder="Ընթացիկ Գաղտնաբառ"/>
                                </div>
                                <div class="col-xs-12">
                                    <label>Նոր Գաղտնաբառ</label><br/>
                                    <input type="text" v-on:change="changeUserPassword" class="form-control" id="new-password" placeholder="նոր Գաղտնաբառ"/>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Չեղարկել</button>
                            <button id="save-change" type="button" v-on:click="saveNewOptions" class="btn btn-success" data-dismiss="modal">Պահպանել
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div v-if="user" class="col-xs-12 col-md-3 logo-holder account-info">
                <a class="edit-user-btn" data-toggle="modal" data-target="#myModal" href="#">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <div class="user-img" style=" height: 85px; width: 85px;  border-radius: 50%;border: 1px solid;border-color: #66c220;overflow: hidden;">
                    <img id="user-set-new-img" v-if="user.img" v-bind:src="`${'assets/images/upload/'+user.img}`"/>
                    <router-link to="/" v-else >
                        <img class="user-img" src="assets/images/Default-welcomer.png"/>
                    </router-link>

                    <label class="edit" for="user-image">
                        <span>Edit</span>
                        <input type="file" id="user-image">
                    </label>

                </div>
                <br>
                <a href="#" class="user-name">{{ user.name }}</a><br>
                <a href="#" class="">Դպրոց` {{ getSchool(user.categoryStructure_id) }}</a><br>
                <a href="#" class="">Պաշտոն` {{  this.position.name}}</a>
            </div>
            <div v-else class="col-xs-12 col-md-3 logo-holder account-info" style="text-align: center">
                <img src="assets/images/logo.png" style="width: 62px; " />
            </div>


            <div class="col-xs-12 col-md-5 top-search-holder no-margin">

                <div class="contact-row">
                    <div v-if="contact" class="phone inline">
                        <i class="fa fa-phone"></i>
                        {{ contact.phone }}
                    </div>
                    <div v-if="contact" class="contact inline">
                        <i class="fa fa-envelope"></i>
                        {{ contact.email }}
                    </div>
                    <div v-if="contact" class="contact inline">
                        <i class="fa fa-map-marker"></i>
                        {{ contact.address }}
                    </div>
                </div>

                <div class="search-area">
                    <form>
                        <div class="control-group">
                            <input v-on:keyup="searchFunc" autocomplete="off" title="" id="search-content" style="width: calc( 100% - 55px )" class="search-field"
                                   placeholder="Որոնում"/>
                            <i v-if="searchWait" class="fa fa-spinner search-wait" aria-hidden="true"></i>
                            <a v-on:click="getSearchResult" class="search-button" href="#"></a>
                            <ul v-if="!isSearchResult" class="search-result">
                                <li v-if="searchNotResult">
                                    <a href="#" title="">Ապրանքներ չեն գտնվել</a>
                                </li>
                                <li v-bind:id="result.id" v-for="result in searchResultProduct">
                                    <a href="#" title="" v-on:click="getSearchResult(result.id)">{{ result.name }} - <span style="color: #808080; font-size: 15px;">{{ result.categoryName }} կատեգորիա</span>, <span style="color: #808080; font-size: 15px;font-weight: bold">(առաջին պահեստում)</span></a>
                                </li>
                                <li v-bind:id="result.id" v-for="result in searchResultFurniture">
                                    <a href="#" title="" v-on:click="getSearchResultFurn(result.id)">{{ result.name }} - <span style="color: #808080; font-size: 15px;">{{ result.categoryName }} կատեգորիա</span>, <span style="color: #808080; font-size: 15px;font-weight: bold">(գույք բաժնում)</span></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-xs-12 col-md-4 top-cart-row no-margin" title="">
                <div class="top-cart-row-container">
                    <div>
                        <router-link class="btn btn-success" to="/order" exact v-if="user" title="" style="margin-bottom: 5px">Նոր Պահանջագիր </router-link>
                        <router-link class="btn btn-success" to="/furnitures" exact v-if="user" title="" style="margin-bottom: 5px">Իմ Գույքը</router-link>
                        <router-link class="btn btn-success" to="/users" exact v-if="position.type == 'director'" title="" style="margin-bottom: 5px">Պատասխանատու</router-link>
                        <router-link class="btn btn-success" to="/ordersFurniture" exact  v-if="position.type == 'director'" style="margin-bottom: 5px"> Գույքի պատվերներ </router-link>
                    </div>

                    <div class="top-cart-holder dropdown animate-dropdown" style="float:right">
                        <div class="basket">

                            <a class="dropdown-toggle" v-on:click="cartOpen()">
                                <div id="cart" class="basket-item-count">
                                    <span class="count">{{this.cartContent.length}}</span>
                                    <img src="assets/images/icon-cart.png" alt=""/>
                                </div>
                                <div class="total-price-basket">
                                    <span class="lbl">Ձեր զամբյուղը:</span>
                                    <i class="icon-trash"></i>
                                    <span class="total-price"></span>
                                    <!--<button >-->

                                    <!--</button>-->

                                </div>
                            </a>

                            <ul id="dropdown-menu-custom" class="dropdown-menu-custom" style="overflow-x: auto; width: 400px;">

                                <li v-bind:id="'item-'+item.product.id" v-for="(item, index) in this.cartContent">
                                    <div class="basket-item" style="padding: 11px 30px 0px 11px;">
                                        <div class="row form-group">
                                            <div class="row">
                                            <div class="col-xs-12 no-margin text-center">
                                                <div v-if="item.product.image" class="thumb" style="height: 41px; width: 46px">
                                                    <img style="height: 100%" v-bind:src="'img/products/'+item.product.image"/>
                                                    <!--<span v-else style="font-size: 13.5px; user-select: none;">Նկար չկա</span>-->
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-xs-12  no-margin">
                                                <div class="title cart-item-title">{{ item.product.name }}</div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-xs-11  no-margin">
                                                <div class="prices product-count">
                                                    <button class="btn btn-default"
                                                            v-on:click="deleteCount('count-'+item.product.id)">-
                                                    </button>
                                                    <input class="count-input asdf" type="number" v-on:change="chageCount(item.product.id,index)" v-bind:id="'count-'+item.product.id" :value="item.count"/>
                                                    <!--<p v-bind:id="'count-'+item.product.id">{{ item.count }}</p>-->
                                                    <button v-bind:id="'btn-count-'+item.product.id"
                                                            v-bind:class="parseInt(item.product.count) > parseInt(item.count)?'btn btn-default':'btn btn-danger'"
                                                            v-on:click="addCount('count-'+item.product.id)"
                                                    >+
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-xs-1 col-sm-1 no-margin">
                                                <button type="button" v-on:click="deleteFromCart(item.product.id)"
                                                        class="btn btn-sm btn-warning">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="checkout">
                                    <div class="basket-item">
                                        <!--<div class="row" v-if="this.cartContent.length">-->
                                            <!--<label>Կրթական օբյեկտ</label>-->
                                            <!--<label class="err-r-mesage" v-if="!selRequired"> Լրացրեք դաշտը</label>-->
                                            <!--<select class="form-control" id="sel1"   v-on:change="selectSchool(selected)"  v-model="selected">-->
                                                <!--<option value="null"></option>-->
                                                <!--<option v-for="school in schools" v-bind:value=school.id>{{school.name}}</option>-->
                                            <!--</select>-->

                                            <!--<br/>-->
                                            <!--&lt;!&ndash;<textarea v-model="orderPurpose" style="max-width: 100%; min-width: 100%"></textarea>&ndash;&gt;-->
                                        <!--</div>-->
                                        <div class="row" v-if="this.cartContent.length && otherSchoolShow">
                                            <label>Այլ Կրթական օբյեկտ</label>
                                            <label class="err-r-mesage" v-if="!selRequiredOtherSchollShow"> Լրացրեք դաշտը</label>
                                            <input
                                                 v-on:change="validateOtherScholl"
                                                 class="form-control"
                                                 name="otherSchool"
                                            >
                                        </div>

                                        <div class="row" v-if="this.cartContent.length">
                                            <label>Շահագործող</label>
                                            <label class="err-r-mesage" v-if="!selRequiredOtherSchollShowName"> Լրացրեք դաշտը</label>
                                            <input
                                                v-on:change="validateOtherSchollName"
                                                class="form-control"
                                                name="otherSchoolName"
                                            >
                                        </div>

                                        <div class="row" v-if="this.cartContent.length">
                                            <label>Նպատակը</label>
                                            <textarea
                                                v-model="orderPurpose"
                                                style="max-width: 100%; min-width: 100%"
                                                class="form-control mb-2">
                                            </textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12">
                                                <button v-if="this.cartContent.length" class="le-button" style="width:100%" v-on:click="confirmOrder">
                                                    Պատվիրել
                                                </button>
                                                <p
                                                        style="text-align:center"
                                                >
                                                    <v-progress-circular
                                                            v-if="loading"
                                                            align="center"
                                                            :width="5"
                                                            :size="80"
                                                            color="green"
                                                            indeterminate
                                                    ></v-progress-circular>
                                                </p>
                                                <h4 style="display: block; text-align: center" v-if="!this.cartContent.length" >Զամբյուղը դատարկ է</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

</template>

<script>

    import axios from 'axios';
    import $ from "jquery";
    import router from "../../router/index";

    export default {
        name: 'Head',
        newName: "",
        currentPassword: "",
        newPassword: "",
        newImg: "",
        isSearchResult:false,
        props: {
            search: null,
            cart: [],
            // selRequired:false,
            selRequiredOtherSchollShow: false,
            selRequiredOtherSchollShowName: false,

            otherSchoolValue:"",
            exploiterValue:""
        },

        data() {
            return {
                otherSchool:true,
                otherSchoolShow: false,
                loading:false,
                user: null,
                contact: null,
                searchResultProduct: [],
                searchResultFurniture: [],
                open: false,
                cartContent: this.$attrs.property,
                searchWait: false,
                searchNotResult: false,
                orderPurpose: "",
                newImgVslid: true,
                schools: [],
                position:[]
                // selectSchools: null,
            }
        },

        // updated() {
        //     if(this.asdf.length){
        //         this.cartContent = this.asdf
        //     }else{
        //         this.$attrs.property = JSON.parse(localStorage.getItem("cartContent"));
        //     }
        //     // alert();
        // },

        mounted() {
            let user_id = JSON.parse(localStorage.getItem('user'));

            this.otherSchoolShow = (user_id.school_id == 16) ? true : false;
            if( this.otherSchoolShow){
                // this.otherS
            }

            if (user_id) {
                user_id = user_id.id;
                let url = "/auth/user/get";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {id: user_id},
                )
                .then((data) => {
                    this.user = data.data.user;
                    this.contact = data.data.contact;
                    this.position= data.data.position;

                })
                .catch((e) => {
                    console.log("exception", e);
                });
            }


        },
        created(){
            this.getSchools();
        },

        methods: {

            getSchool(myid){
                let school = null;
                let id = parseInt(myid);
                this.schools.forEach(function (value) {
                    if(value.id == id){
                        school =  value.category;
                        return '';
                    }
                });
                return school;
            },

            chageCount(id,index){
                this.cartContent[index].count = document.getElementById("count-"+id).value;
                localStorage.setItem("cartContent", JSON.stringify(this.cartContent));
            },

            cartOpen() {
                this.open = !this.open;
                if (this.open) {
                    document.getElementById("dropdown-menu-custom").style.display = "block"
                } else {
                    document.getElementById("dropdown-menu-custom").style.display = "none"
                }
            },

            changeUserName(e) {
                this.newName = e.target.value;
            },
            currentUserPassword(e){
                this.currentPassword = e.target.value;
            },
            changeUserPassword(e){
                this.newPassword = e.target.value;
            },
            changeUserImg(e) {
                if(e.target.files[0].type=="image/png" || e.target.files[0].type=="image/jpeg"){
                    this.newImg = e.target.files[0];
                    $("#new-img-block").css({border:"none"});
                    $("#save-change").prop("disabled",false);
                    this.newImgVslid = true;
                    this.readURL(e.target);
                }else{
                    this.newImg = "";
                    this.newImgVslid = false;
                    $("#new-img-block").css({border:"2px red solid"});
                    $("#new-img-block").src(e.target.files[0]);
                    $("#save-change").prop("disabled",true);
                }
            },
            readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#user-new-image').attr('src', e.target.result);
                        $('#user-set-new-img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            },

            getPurpose(event){
                console.log(event.target.value);
            },

            saveNewOptions() {

                let formData = new FormData(document.getElementById('change-form'));
                formData.append('img', this.newImg);
                formData.append('name', this.newName);
                formData.append('currentPassword', this.currentPassword);
                formData.append('newPassword', this.newPassword);
                formData.append('id', this.user.id);
                // console.log(formData);

                var url = "auth/user/change";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then((data) => {
                    //console.log(data.data);
                    $('#user-set-new-img').attr('src', 'assets/images/upload/'+data.data.newImg);
                    $('#user-new-img').attr('src', 'assets/images/upload/'+data.data.newImg);
                    $('.user-name').html(data.data.newName);
                })
                .catch((e) => {
                    console.log("exception", e);
                });
            },

            searchFunc(event) {

                let data = $('#search-content').val();
                if(data.length>1 && this.searchResultProduct && this.searchResultFurniture){
                    this.searchWait = true;
                    this.isSearchResult = false;
                }else{
                    this.searchWait = false;
                }
                if (data.length>1) {
                    var url = "auth/productsAndFurnitures";
                    // console.log(this.cartContent);
                    axios.post(
                        url,
                        {search: data, category: this.$attrs.filterByCategory}
                    )
                        .then((data) => {
                            this.searchResultProduct = data.data.product;
                            this.searchResultFurniture = data.data.furniture;
                            this.searchWait = false;
                            // console.log(data.data);

                            if(!data.data.product.length && !data.data.furniture.length && $('#search-content').val().length > 1){
                                this.searchNotResult = true;
                            }else{
                                this.searchNotResult = false;
                            }

                        })
                        .catch((e) => {
                            console.log("exception", e);
                        });

                } else {
                    this.searchResultProduct = [];
                    this.searchResultFurniture = [];
                }
            },

            getSchools(){
                var url = "auth/categoriesStructure";
                axios.post(
                    url,
                )
                .then((data) => {
                    this.schools = data.data;
                    // console.log('qoleg', schools);
                })
                .catch((e) => {
                });
            },

            getSearchResult(event = null) {
                $("#search-content").val("");
                if(!this.searchResultProduct.length && !this.searchResultFurniture){

                    $("#search-content").attr("placeholder", "Ապրանքներ չեն գտնվել");
                }

                this.searchWait = false;
                let data = [];
                if (!Number.isInteger(event)) {
                    for (let i = 0; i < this.searchResultProduct.length; i++) {
                        data.push(this.searchResultProduct[i].id);
                    }
                } else {
                    data.push(event);
                }
                // console.log('prod',data);
                this.$attrs.title(data);
                // this.$attrs.title(dataFurn);

                this.searchResultProduct = [];
                this.isSearchResult = true;
            },

            getSearchResultFurn(event = null) {
                $("#search-content").val("");
                if(!this.searchResultProduct.length && !this.searchResultFurniture){
                    $("#search-content").attr("placeholder", "Ապրանքներ չեն գտնվել");
                }

                this.searchWait = false;
                let dataFurn = [];
                if (!Number.isInteger(event)) {
                    for (let i = 0; i < this.searchResultFurniture.length; i++) {
                        dataFurn.push(this.searchResultFurniture[i].id);
                    }
                } else {
                    dataFurn.push(event);
                }
                // console.log('furn',dataFurn);
                this.$attrs.title(dataFurn);
                // this.$attrs.title(dataFurn);
                this.searchResultFurniture = [];
                this.isSearchResult = true;
            },

            addCount(id) {
                for (let i = 0; i < this.cartContent.length; i++) {
                    if (id.split("-")[1] == this.cartContent[i].product.id) {
                        if (this.cartContent[i].product.count <= this.cartContent[i].count) {

                            let element = document.getElementById('btn-' + id);
                            element.className = "btn btn-danger";
                            element.setAttribute("title", "Պահեստում չկա");
                            return;
                        }else{
                            this.cartContent[i].count++;
                            //console.log(this.cartContent[i].product.count, this.cartContent[i].count);
                            return
                        }
                    }
                }
                localStorage.setItem("cartContent", JSON.stringify(this.cartContent));
            },

            deleteCount(id) {
                for (let i = 0; i < this.cartContent.length; i++) {
                    if (id.split("-")[1] == this.cartContent[i].product.id && this.cartContent[i].count > 1) {
                        this.cartContent[i].count--;
                        if (this.cartContent[i].product.count == this.cartContent[i].count) {
                            let element = document.getElementById('btn-' + id);
                            element.className = "btn btn-default";
                            element.setAttribute("title", "etqan chka");
                        }

                    }
                }
                localStorage.setItem("cartContent", JSON.stringify(this.cartContent));
            },

            deleteFromCart(id) {
                for (let i = 0; i < this.cartContent.length; i++) {
                    if (id == this.cartContent[i].product.id) {
                        this.cartContent.splice(i, 1);
                    }
                }
                localStorage.setItem("cartContent", JSON.stringify(this.cartContent));
            },

            // selectSchool(data){
            //     if(data == 'null'){
            //         this.selRequired = false;
            //     }else{
            //         if (data == 16){
            //             this.otherSchoolShow = true;
            //         }else{
            //             this.otherSchoolShow = false;
            //         }
            //         this.selRequired = true;
            //         this.selectSchools = data;
            //     }
            // },

            validateOtherScholl(e){
                const value = e.target.value;
                this.otherSchoolValue = value;
                if(value != ''){
                    this.selRequiredOtherSchollShow = true;
                }else{
                    this.selRequiredOtherSchollShow = false;
                }

                return value;
            },

            validateOtherSchollName(e){
                const value = e.target.value;
                this.exploiterValue = value;
                if(value != ''){
                    this.selRequiredOtherSchollShowName = true;
                }else{
                    this.selRequiredOtherSchollShowName= false;
                }

                return value;
            },

            confirmOrder() {
                if(this.selRequiredOtherSchollShowName){
                    if(this.otherSchoolShow){
                        if(!this.selRequiredOtherSchollShow){
                            return;
                        }
                    }



                    if (JSON.parse(localStorage.getItem("user"))) {

                        var url = "auth/order";
                        this.loading = true;
                        axios.post(
                            url,
                            {
                                otherSchoolValue: this.user.categoryStructure_id,
                                exploiterValue: this.exploiterValue ? this.exploiterValue : null,
                                // school: this.selectSchools,
                                products: this.cartContent,
                                user: JSON.parse(localStorage.getItem("user")).id,
                                purpose: this.orderPurpose
                            },
                        )
                            .then((data) => {
                                this.loading = false;
                                swal({
                                    html:"<h5>Պատվերը հաջողությամբ գրանցվեց</h5>"
                                });
                                while(this.cartContent.length > 0) {
                                    this.cartContent.pop();
                                }
                                this.$parent.$options.methods.filterFunc();
                                document.getElementById("dropdown-menu-custom").style.display = "none";
                                localStorage.removeItem("cartContent");
                            })
                            .catch((e) => {
                                this.loading = false;
                                router.push('login')

                                // swal("մուտք գործեք !");
                            });

                    } else {
                        router.push('login')
                        // swal("մուտք գործեք !");
                    }
                }

            }

        }
    }
</script>
<style>

    .search-wait{
        position: absolute;
        right: 60px;
        font-size: 25px;
        top: 23px;
        animation: spinner 2s linear infinite;
    }

    @keyframes spinner {
        100% {
            transform: rotate(360deg);
        }
    }
    #new-img{
        display: none;
    }

</style>
