<script src="home/armen/Desktop/Grigor js/assets/js/script.js"></script>
<template>

    <div class="wrapper">

        <div class="container">
            <div class="row">
                <label>Ֆիլտեր</label>
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <div>Ժամանակ</div>
                        <vue-rangedate-picker style="width: 100%" @selected="onDateSelected" i18n="EN" format="YYYY-MM-DD hh:mm:ss"></vue-rangedate-picker>
                    </div>
                    <div class="col-xs-6">
                        <div>Կարգավիճակ</div>

                        <multiselect
                                language="es"
                                v-model="value"
                                :options="statuses"
                                :multiple="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :hide-selected="true"
                                :preserve-search="true"
                                placeholder="Ընտրել Կարգավիճակ"
                                label="text"
                                track-by="text"
                                :preselect-first="true"
                                id="status-filter"
                                @select="onSelect"
                                @remove="deselectLabel"
                                open-direction="bottom"
                                :searchable="true"
                                :options-limit="300"
                                :max-height="600"
                                :show-no-results="false"
                        >
                        </multiselect>
                    </div>
                    <div class="col-xs-2">
                        <br>
                        <button class="btn btn-success" v-on:click="resetFilter">Մաքրել</button>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-group btn-group-lg" style="width: 100%" role="group" aria-label="Large button group">
                        <button type="button" v-on:click="categorytabs(0)" style="width: 50%" v-bind:class="tabIndex==1?'btn btn-default':'btn btn-success'">Պահեստի պատվերներ</button>
                        <button type="button" v-on:click="categorytabs(1)" style="width: 50%" v-bind:class="tabIndex==0?'btn btn-default':'btn btn-success'">Պահանջագրով պատվերներ</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <download-excel class="btn btn-success" :data="downloadExel" :fields="json_fields" name="OrderList.xls">
                        Արտահանել
                    </download-excel>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead style="background: #212529; color: white">
                            <tr>
                                <th>Հաստատություն</th>
                                <th>#</th>
                                <th>Անուն</th>
                                <th>Քանակ (Հաստատված) </th>
                                <th>Միավոր</th>
                                <th>Կարգավիճակը</th>
                                <th>Կոդ</th>
                                <th>Նպատակ</th>
                                <th>Պահեստ</th>
                                <th style="text-align: right">Կարգավորում</th>
                            </tr>
                        </thead>
                        <tbody v-for="orderGroup in asdf" >
                        
                        <tr>
                            <td colspan="10" style="background: rgb(110,118,125); color: #fff; font-weight: bold; cursor:pointer" v-on:click="showOrderDetails(orderGroup.id)">
                                Պատվեր #{{orderGroup.id}} <span style="text-align:right; float: right; width: 300px; display: block;"> {{ orderGroup.date.date }} </span>
                            </td>
                        </tr>
                        <tr v-bind:class="'child-order-'+orderGroup.id" v-for="orders in orderGroup.orders" style="display: none;" class="orderDetails">
                            <td v-if="orders.school_id != 16">{{orders.schoolName}}</td>
                            <td v-if="orders.school_id == 16">{{orders.schoolName}} ({{ orders.edu_obj }})</td>
                            <td>
                                <img v-if="orders.productImg" :src="'img/products/'+orders.productImg" width="35">
                                <img v-else src="https://www.imcusa.org/global_graphics/default-store-350x350.jpg" width="35">
                            </td>
                            <td><a download="" :href="'/assets/images/upload/'+orders.productName">{{orders.productName}}</a></td>
                            <td>{{orders.count}} <span v-if="orders.approved" style="color: red;">( {{orders.approved}} )</span></td>
                            <td>{{orders.unit}}</td>
                            <td v-if="orders.status=='pending'">Սպասման մեջ</td>
                            <td v-if="orders.status=='canceled_by_customer'">Հաճախորդի կողմից չեղարկված</td>
                            <td v-if="orders.status=='canceled_by_admin'">Ադմինի կողմից չեղարկված</td>
                            <td v-if="orders.status=='archive'">Արխիվ</td>
                            <td v-if="orders.status=='complete'">Ավարտված</td>
                            <td v-if="orders.status=='approved'">Հաստատված</td>
                            <td>{{orders.code}}</td>
                            <td>{{orders.reason}}</td>
                            <td v-if="orders.storage==0">Առաջին պահեստ</td>
                            <td v-if="orders.storage==1">Երկրորդ պահեստ</td>
                            <td v-if="orders.storage==null"></td>
                            <td style="text-align: right">
                                <button v-if="orders.status=='canceled_by_customer' || orders.status=='canceled_by_admin' || orders.status=='complete'" class="btn btn-sm btn-danger" v-on:click="toArchive(orders.id, orders.count)">Արխիվ</button>
                                <button v-if="orders.status=='pending' && !orders.approved" class="btn btn-sm btn-danger" v-on:click="cancelOrder(orders.id, orders.count)">Չեղարկել</button>
                                <button v-else class="btn btn-sm btn-warning" v-on:click="reOrder(orders.id, orders.count,orders.details_id)">Պատվիրել նորից</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="isPreloader" >
                    <div style="margin:0 auto;width:70px">
                        <img src="../../img/preloader.gif" alt="" >
                    </div>

                </div>
                <div class="col-xs-12" style="text-align: center" v-if="history.length>10">
                    <paginate
                            v-model="page"
                            :page-count="Math.floor(history.length/10)"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="goToPage"
                            :prev-text="'Նախորդ'"
                            :next-text="'Հաջորդ'"
                            :container-class="'pagination'"
                            :page-class="'page-item'">
                    </paginate>
                </div>

            </div>
        </div>
    </div>

</template>
<script>

    import JsonExcel from 'vue-json-excel';

    import $ from "jquery";

    import Multiselect from 'vue-multiselect';
    import VueRangedatePicker from 'vue-rangedate-picker';
    import Paginate from 'vuejs-paginate';


    export default {
        name: "Orders",
        data() {
            return {
                asdf: [],
                isPreloader:true,
                date: new Date(2016, 9,  16),
                page: 0,
                value: [{text: "Հաստատված", value: "approved"},{text: "Սպասման մեջ", value: "pending"}],
                filterByStatus: [],
                filterByDate: [],

                statuses: [
                    {text: "Սպասման մեջ", value: "pending"},
                    {text: "Ադմինի կողմից չեղարկված", value: "canceled_by_admin"},
                    {text: "Հաճախորդի կողմից չեղարկված", value: "canceled_by_customer"},
                    {text: "Ավարտված", value: "complete"},
                    {text: "Հաստատված", value: "approved"},
                    {text: "Արխիվ", value: "archive"},
                ],
                tabIndex: 0,
                history: [],
                downloadExel: [],
                json_fields: {
                    'Հաստատություն' : 'schoolName',
                    'Համար'         : 'id',
                    'Անուն'         : 'productName',
                    'Քանակ'         : 'count',
                    'Միավոր'        : 'unit',
                    'Կոդ'           : 'code',
                    'Ստեղծվել է'    : 'created_at',
                    'Կարգավիճակ'    : "status",
                    "նպատակը"       : "purpose"
                },
                json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ],

                selectedDate: {
                    start: '',
                    end: ''
                }

            }
        },

        mounted() {
            this.getMyOrders();
        },

        updated(){

        },

        components: {
            Multiselect,
            VueRangedatePicker,
            downloadExcel: JsonExcel,
            Paginate
        },

        methods: {

            resetFilter(){
                this.filterByStatus = [];
                this.filterByDate = [];
                this.getMyOrders();
            },

            goToPage(pageNum){
                this.page = pageNum;
                this.productSorting();
            },

            toArchive(id, count){
                console.log(arguments);
            },


            onDateSelected: function (daterange) {
                this.selectedDate = daterange;
                this.filterByDate = [this.dateFormat(daterange.start), this.dateFormat(daterange.end)];
                this.getMyOrders();
            },

            dateFormat(changeData){
                var date = new Date(changeData);
                var mnth = ("0" + (date.getMonth()+1)).slice(-2);
                var day  = ("0" + date.getDate()).slice(-2);
                return [ date.getFullYear(), mnth, day ].join("-");
            },

            onSelect (option, id) {
                this.filterByStatus.push(option.value);
                this.getMyOrders();
            },
            deselectLabel(option, id){
                for(let i = 0; i < this.filterByStatus.length; i++){
                   if(this.filterByStatus[i] == option.value){
                       this.filterByStatus.splice(i, 1);
                   }
                }
                this.getMyOrders();
            },

            categorytabs(tab){
                this.tabIndex = tab;
                this.getMyOrders();
                this.isPreloader = true;
            },

            logout() {
                this.$router.go("Login");
                this.$store.dispatch('logout');
            },

            showOrderDetails(id){
                $(".child-order-"+id).toggle();
            },

            getMyOrders() {

                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/orders";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id, orderType: this.tabIndex, status: this.filterByStatus, date: this.filterByDate},
                )
                .then((response) => {
                    this.history = response.data;
                    this.productSorting();
                    var arr = [];
                    for(let i = 0; i < response.data.length; i++){
                        arr.push({
                            schoolName: "",
                            id: response.data[i].id,
                            school_id: response.data[i].school_id,
                            productName:"",
                            count: "",
                            unit: "",
                            code: "",
                            created_at: response.data[i].date + " # " + response.data[i].id,
                            status: "",
                            edu_obj: "",
                            exploiter: "",
                        });
                        for(let j = 0; j < response.data[i].orders.length; j++){
                            arr.push({
                                schoolName: response.data[i].orders[j].schoolName,
                                id: response.data[i].orders[j].id,
                                productName: response.data[i].orders[j].productName,
                                count: response.data[i].orders[j].count ,
                                unit: response.data[i].orders[j].unit,
                                code: response.data[i].orders[j].code,
                                image: response.data[i].orders[j].image,
                                created_at: response.data[i].orders[j].date,
                                status: this.getTranslate(response.data[i].orders[j].status),
                                purpose: response.data[i].orders[j].reason,
                                edu_obj: response.data[i].orders[j].edu_obj,
                                exploiter: response.data[i].orders[j].exploiter,
                                school_id: response.data[i].orders[j].school_id
                            });
                        }
                    }
                    this.downloadExel = arr;
                    this.isPreloader = false;
                })
                .catch((e) => {
                    console.log("exception", e);
                });
            },

            getTranslate(data){
                switch (data) {
                    case "pending":
                        return "Սպասման մեջ";
                    case "complete":
                        return "Ավարտված"
                    case "archive":
                        return "Արխիվ"
                    case "approved":
                        return "Հաստատված"
                    case "canceled_by_admin":
                        return "Ադմինի կողմից չեղարկված"
                    case "canceled_by_customer":
                        return "Հաճախորդի կողմից չեղարկված"
                }
            },

            productSorting(){
                var data = this.history;

                let startPage = (this.page-1) * 10;

                if(startPage<0){
                    startPage = 0;
                }
                let endPage = startPage + 10;

                if(!data[endPage]){
                    endPage = data.length;
                }
                this.asdf = [];
                for (let i = startPage; i < endPage; i++) {
                    this.asdf.push(this.history[i]);
                }
            },

            cancelOrder(id, count){
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/orders/cancel";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id, order_id: id, orderType: this.tabIndex, order_count: count, status: this.filterByStatus, date: this.filterByDate},
                )
                .then((response) => {

                    this.history = response.data;
                    this.productSorting();

                    var arr = [];
                    for(let i = 0; i < response.data.length; i++){
                        arr.push({
                            schoolName: "",
                            id: response.data[i].id,
                            productName:"",
                            count:"",
                            unit:"",
                            code:"",
                            created_at: response.data[i].date + " # " + response.data[i].id,
                            status:"",
                            purpose: ""
                        });
                        for(let j = 0; j < response.data[i].orders.length; j++){
                            arr.push({
                                schoolName: response.data[i].orders[j].schoolName,
                                id: response.data[i].orders[j].productName,
                                productName: response.data[i].orders[j].productName,
                                // count: response.data[i].orders[j].count + "(" + response.data[i].orders[j].approved + ")",
                                count: response.data[i].orders[j].count,
                                unit: response.data[i].orders[j].unit,
                                code: response.data[i].orders[j].code,
                                created_at: response.data[i].orders[j].date,
                                status: response.data[i].orders[j].status,
                                purpose: response.data[i].orders[j].reason
                            });
                        }
                    }
                    this.downloadExel = arr;
                    this.isPreloader = false;
                })
                .catch((e) => {
                    console.log("exception", e);
                });

            },

            toArchive(id, count){
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/orders/archive";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id, order_id: id, orderType: this.tabIndex, order_count: count, status: this.filterByStatus, date: this.filterByDate},

                )
                    .then((response) => {

                        this.history = response.data;
                        this.productSorting();

                        var arr = [];
                        for(let i = 0; i < response.data.length; i++){
                            arr.push({
                                schoolName: "",
                                id: response.data[i].id,
                                productName: "",
                                count: "",
                                unit: "",
                                code: "",
                                created_at: response.data[i].date + " # " + response.data[i].id,
                                status: "",
                                purpose: ""
                            });
                            for(let j = 0; j < response.data[i].orders.length; j++){
                                arr.push({
                                    schoolName: response.data[i].orders[j].schoolName,
                                    id: response.data[i].orders[j].productName,
                                    productName: response.data[i].orders[j].productName,
                                    // count: response.data[i].orders[j].count + "(" + response.data[i].orders[j].approved + ")",
                                    count: response.data[i].orders[j].count,
                                    unit: response.data[i].orders[j].unit,
                                    code: response.data[i].orders[j].code,
                                    created_at: response.data[i].orders[j].date,
                                    status: response.data[i].orders[j].status,
                                    purpose: response.data[i].orders[j].reason
                                });
                            }
                        }
                        this.downloadExel = arr;
                        // console.log(arr);
                        this.isPreloader = false;

                        // this.history = response.data;
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });

            },

            reOrder(id, count,detailsId){
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/orders/reorder";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id, order_id: id, detailsId:detailsId, orderType: this.tabIndex, order_count: count, status: this.filterByStatus, date: this.filterByDate},

                )
                .then((response) => {

                    this.history = response.data;
                    this.productSorting();

                    var arr = [];
                    for(let i = 0; i < response.data.length; i++){
                        arr.push({
                            schoolName: "",
                            id: response.data[i].id,
                            productName: "",
                            count: "",
                            unit: "",
                            code: "",
                            created_at: response.data[i].date + " # " + response.data[i].id,
                            status: "",
                            purpose: ""
                        });
                        for(let j = 0; j < response.data[i].orders.length; j++){
                            arr.push({
                                schoolName: response.data[i].orders[j].schoolName,
                                id: response.data[i].orders[j].productName,
                                productName: response.data[i].orders[j].productName,
                                count: response.data[i].orders[j].count,
                                unit: response.data[i].orders[j].unit,
                                code: response.data[i].orders[j].code,
                                created_at: response.data[i].orders[j].date,
                                status: response.data[i].orders[j].status,
                                purpose: response.data[i].orders[j].reason
                            });
                        }
                    }
                    this.downloadExel = arr;
                    this.isPreloader = false;

                })
                .catch((e) => {
                    console.log("exception", e);
                });
            }

        }
    }

</script>

<style scoped>
    .input-date{
        width: 100% !important;
    }


</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
