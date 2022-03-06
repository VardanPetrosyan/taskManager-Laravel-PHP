<template>

    <div class="wrapper">


        <section id="category-grid">
            <div class="container">

                <div class="col-xs-12 wide ">
                    <section id="recommended-products" class="carousel-holder hover small">

                        <div class="title-nav">
                            <h2 class="inverse">Պատվիրել այստեղ</h2>
                            <div class="nav-holder">
                                <a href="#prev" data-target="#owl-recommended-products"
                                   class="slider-prev btn-prev fa fa-angle-left"></a>
                                <a href="#next" data-target="#owl-recommended-products"
                                   class="slider-next btn-next fa fa-angle-right"></a>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </section>

        <section>
            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անվանում</th>
                                <!--<th scope="col">Կատեգորիա</th>-->
                                <th scope="col">Քանակ</th>
                                <th scope="col">Միավոր</th>
                                <!--<th scope="col">ամսաթիվ</th>-->
                                <!--<th scope="col">Օգտագործման վայրը, օգտագործող անձը</th>-->
                                <th scope="col">Պատվիրատու</th>
                                <th scope="col">Նպատակ</th>
                                <th scope="col">Շտապ</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in orderData">
                                <th>{{items.name}}</th>
                                <td>{{items.count}}</td>
                                <td>{{items.unit}}</td>
                                <!--<td>{{// new Date()}}</td>-->
                                <td>{{user.name}}</td>
                                <td>{{items.reason}}</td>
                                <td v-if="items.urgent">Շտապ</td>
                                <td v-else></td>
                                <td style="text-align: center" class="confirm-block-control">
                                    <button class="btn btn-sm btn-warning" v-on:click="edit(index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" v-on:click="remove(index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td>
                                    <button v-if="!openAddBlock" v-on:click="add" style="width: 100%"
                                            class="btn btn-success pull-right">+
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                        <label> ժամկետ (Մինչև)</label>
                        <!--<label  class="err-r-mesage" v-if="!dateValid"> Լրացրեք դաշտը</label>-->
                        <datepicker id="order-dateTo" class="form-controll"></datepicker>
                        <button v-if="!openAddBlock && orderData.length"
                                style="display: block; margin: 0 auto; text-align: center" class="btn btn-success"
                                v-on:click="sendData">Հաստատել
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
                        <div v-if="openAddBlock" class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">
                                <div class="col-xs-6">
                                    <label>Անվանում</label>
                                    <label class="err-r-mesage" v-if="!nameValid"> Լրացրեք դաշտը</label>
                                    <input id="order-name" class="form-control"
                                           :value="oldvalues?oldvalues.name:oneOrder?oneOrder.name:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Քանակ</label>
                                    <label class="err-r-mesage" v-if="!countValid"> Լրացրեք դաշտը</label>
                                    <input type="number" id="order-count" class="form-control"
                                           :value="oldvalues?oldvalues.count:oneOrder?oneOrder.count:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Միավոր</label>
                                    <label class="err-r-mesage" v-if="!unitValid"> Լրացրեք դաշտը</label>
                                    <select id="order-unit" class="form-control">
                                        <option v-for="unit in units" v-bind:value="unit.id">{{unit.unit}}</option>
                                    </select>
                                </div>
                                <!--<div class="col-xs-6">-->
                                <!--<label>Դպրոց</label>-->
                                <!--<select class="form-control" id="order-school" v-on:change="selectSchool(selected)"  v-model="selected">-->
                                <!--<option value="null"></option>-->
                                <!--<option v-if="school.parent_category_id == null"  v-for="school in schools" v-bind:value=school.id >{{school.category}}</option>-->
                                <!--</select>-->
                                <!--</div>-->
                            </div>

                            <!--<datepicker class="form-controll" ></datepicker>-->
                            <!--<label>Պատվիրատու</label>-->
                            <!--<p>{{user.name}}</p>-->
                            <div class="col-xs-6">
                                <!--<input type="datetime-local">-->
                                <label>Նպատակ, Տեխ. բնութագիր/Պատասխանատու անձ</label>
                                <label class="err-r-mesage" v-if="!reasonValid"> Լրացրեք դաշտը</label>
                                <textarea id="order-reason" style="max-width: 100%; min-width: 100%"
                                          class="form-control"
                                          :value="oldvalues?oldvalues.reason:oneOrder?oneOrder.reason:''"></textarea>
                                <!--</div>-->

                                <!--<br>-->
                                <!--<div class="col-xs-12">-->
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <div>
                                        <label>Շտապ</label>
                                        <input style="width: 30px; height: 20px " type="checkbox" id="order-urgent"
                                               class="form-control">
                                    </div>
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="save">Ավելացնել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="add()">Չեղարկել
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!--<h2 style="display: block; margin: 0 auto; text-align: center"><b>կամ</b></h2>-->
                        <!--<h3 style="display: block; margin: 0 auto; text-align: center">Վերբեռնել ֆայլ</h3>-->
                        <!--<br/>-->

                    </div>
                </div>
            </div>
            <!--<div class="container confirm-block">-->
            <!--<div class="row">-->
            <!--<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">-->
            <!--<form>-->
            <!--<label class="upload-file" for="upload-file-inp">-->
            <!--<input v-on:change="uploadFile" type="file" id="upload-file-inp" />-->
            <!--<i class="fa fa-cloud-upload" aria-hidden="true"></i>-->
            <!--</label>-->
            <!--<div v-for="(files, index) in orderUploadFile" class="uploaded-file">-->
            <!--<i v-on:click="removeUploadedFile(index)" class="fa fa-times" aria-hidden="true"></i>-->
            <!--<div class="uploaded-file-icon">-->
            <!--<i class="fa fa-file-word-o" aria-hidden="true"></i>-->
            <!--</div>-->
            <!--<div class="uploaded-file-info">-->
            <!--<span><b>name: </b>{{files.name}}</span><br>-->
            <!--<span><b>size: </b>{{Math.floor(files.size/1024)}}KB</span>-->
            <!--</div>-->
            <!--<hr>-->
            <!--</div>-->
            <!--<br>-->
            <!--<button v-if="orderUploadFile.length" class="confirm-btn btn btn-success" v-on:click="sendUploadedFile">Հաստատել</button>-->
            <!--</form>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
        </section>

    </div>


</template>

<script>

    import Datepicker from 'vuejs-datepicker';


    export default {
        name: "CustomOrder",
        data() {
            return {
                loading: false,
                thisDate: new Date().setDate(new Date().getDate() + 7),
                units: [],
                orderData: [],
                orderUploadFile: [],
                oneOrder: null,
                oldvalues: null,
                openAddBlock: false,
                user: JSON.parse(localStorage.getItem("user")),
                nameValid: true,
                countValid: true,
                unitValid: true,
                dateValid: true,
                reasonValid: true,
                urgentValid: true,
                schools: []
            }
        },
        mounted() {
            this.getUnits();
            this.getSchools();
            var dateTo = document.getElementById('order-dateTo');
            dateTo.style.border = '1px solid #dcdcdc';
        },
        components: {
            Datepicker
        },

        methods: {

            getUnits() {
                let url = "/auth/products/units";
                axios.post(
                    url,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then((data) => {
                        this.units = data.data;
                        console.log(data.data);
                        // this.orderUploadFile = [];
                        // swal("Ձեր պատվերը ընդունված է");
                    })
                    .catch((e) => {
                        console.log('exception', e);
                    });
            },


            edit(id) {

                this.oneOrder = {
                    name: this.orderData[id].name,
                    count: this.orderData[id].count,
                    unit: this.orderData[id].unit,
                    school: this.orderData[id].school,
                    reason: this.orderData[id].reason,
                    urgent: this.orderData[id].urgent,
                };

                // console.log(this.orderData[id]);
                this.openAddBlock = true;
                this.remove(id);
            },

            remove(id) {
                if (!id && this.openAddBlock) {
                    // this.openAddBlock = false;
                }
                this.orderData.splice(id, 1);
            },

            add() {
                this.openAddBlock ? this.openAddBlock = false : this.openAddBlock = true
            },

            getSchools() {
                var url = "auth/categoriesStructure";
                axios.post(
                    url,
                )
                    .then((data) => {
                        this.schools = data.data;
                    })
                    .catch((e) => {
                    });
            },


            selectSchool(data) {
                this.orderData.school = data;
            },

            save() {

                var name = document.getElementById('order-name');
                var count = document.getElementById('order-count');
                var unit = document.getElementById('order-unit');
                var school = this.user.categoryStructure_id;
                var reason = document.getElementById('order-reason');
                var urgent = document.getElementById('order-urgent').checked;
                // var dateTo = document.getElementById('order-dateTo');
                // console.log(dateTo.value);
                // console.log(urgent);

                !name.value ? this.nameValid = false : this.nameValid = true;
                !count.value ? this.countValid = false : this.countValid = true;
                !unit.value ? this.unitValid = false : this.unitValid = true;
                !reason.value ? this.reasonValid = false : this.reasonValid = true;


                if (name.value && count.value && unit.value && reason.value) {
                    this.orderData.push({
                        school: this.user.categoryStructure_id,
                        name: name.value,
                        count: count.value,
                        unit: unit.value,
                        reason: reason.value,
                        urgent: urgent,
                        user: this.user.id,
                        // dateTo      : dateTo.value,
                    });
                    this.oldvalues = null;
                    this.openAddBlock = false;
                } else {
                    this.oldvalues = {
                        school: this.user.categoryStructure_id,
                        name: name.value,
                        count: count.value,
                        unit: unit.value,
                        reason: reason.value,
                        urgent: urgent,
                        user: this.user.id,
                        // dateTo      : dateTo.value,
                    }
                }


            },


            sendData() {
                // console.log(this.orderData);
                this.loading = true;
                var dateTo = document.getElementById('order-dateTo').value;
                // console.log(this.orderData);

                let url = "/auth/products/reserve";
                axios.post(
                    url,
                    {date: dateTo, data: this.orderData, type: 0, orderType: 1},
                )
                    .then((data) => {
                        this.loading = false;
                        document.getElementById('order-dateTo').value = '';
                        // console.log(data);
                        if (this.orderData.length) {
                            swal("Ձեր պատվերը ընդունված է");
                            this.orderData = [];
                        }
                    })
                    .catch((e) => {
                        this.loading = false;
                        console.log('exception', e);
                    });

            },


            uploadFile(event) {
                this.orderUploadFile.push(event.target.files[0]);
            },

            removeUploadedFile(index) {
                this.orderUploadFile.splice(index, 1);
            },

            sendUploadedFile() {

                var data = new FormData();

                for (let i = 0; i < this.orderUploadFile.length; i++) {
                    data.append("data[]", this.orderUploadFile[i]);
                }
                data.append("user", this.user.id);
                data.append("orderType", 1);

                let url = "/auth/products/reserve";
                axios.post(
                    url,
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then((data) => {
                        this.orderUploadFile = [];
                        swal("Ձեր պատվերը ընդունված է");
                    })
                    .catch((e) => {
                        console.log('exception', e);
                    });
            }


        }
    }
</script>

<style scoped>
    .v-progress-circular {

        margin: 1rem
    }

</style>
