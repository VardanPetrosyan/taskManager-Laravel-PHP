<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="container">

        <div class="btn-group btn-group-lg" style="width: 100%" role="group"
             aria-label="Large button group">
            <button type="button" v-on:click="furnitureTabs(0)"
                    :style="userPosition.type == 'director'?'width: 33%; padding-left: 5px;':'width: 50%; padding-left: 5px;'"
                    v-bind:class="tabIndex==0?'btn btn-success':'btn btn-default'">Տեսնել Գույքը
            </button>
            <button type="button" v-on:click="furnitureTabs(1)"
                    :style="userPosition.type == 'director'?'width: 33%; padding-left: 5px;':'width: 50%; padding-left: 5px;'"
                    v-bind:class="tabIndex==1?'btn btn-success':'btn btn-default'">Ավելացնել Գույք
            </button>
            <button type="button" v-if="userPosition.type == 'director'" v-on:click="furnitureTabs(2)"
                    style="width: 33%;padding-left: 3px;"
                    v-bind:class="tabIndex==2?'btn btn-success':'btn btn-default'">Սպասում են ուղարկման
            </button>
            <button type="button" v-if="userPosition.type == 'director'" v-on:click="furnitureTabs(3)"
                    style="width: 33%;padding-left: 3px;"
                    v-bind:class="tabIndex==3?'btn btn-success':'btn btn-default'">Սպասում են ընդունման
            </button>
            <button type="button" v-if="userPosition.type == 'director'" v-on:click="furnitureTabs(4)"
                    style="width: 33%;padding-left: 3px;"
                    v-bind:class="tabIndex==4?'btn btn-success':'btn btn-default'">Պատվիրված
            </button>
            <button type="button" v-if="userPosition.type == 'director'" v-on:click="furnitureTabs(5)"
                    style="width: 33%;padding-left: 3px;"
                    v-bind:class="tabIndex==5?'btn btn-success':'btn btn-default'">Պատմություն
            </button>
        </div>
        <hr/>

        <section v-if="tabIndex==0">

            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <download-excel class="btn btn-success" :data="downloadExelFurniture"
                                        :fields="json_fields_Furnitures"
                                        name="FurnitureList.xls">
                            Արտահանել
                        </download-excel>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Կոդ</th>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Կարգավիճակ</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in showedFurniture">
                                <th>{{items.code}}</th>
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category_id) }}</td>
                                <td v-if="items.status == 'in_use'"> Օգտագործվում է</td>
                                <td v-if="items.status == 'unnecessary'"> Չի օգտագործվում</td>
                                <td v-if="items.status == 'sended'"> ՈՒղարկված ({{
                                    getSchool(items.sended_to_categoryStructure_id) }})
                                </td>
                                <td v-if="items.status == 'ordered'"> Պատվիրված ({{
                                    getSchool(items.ordered_from_categoryStructure_id) }})
                                </td>
                                <td>{{items.count}}</td>
                                <td>{{items.description}}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td v-if="userPosition.type == 'director'" style="text-align: center"
                                    class="confirm-block-control">
                                    <button v-if="items.status != 'ordered'" title="Փոփոխել"
                                            class="btn btn-sm btn-warning"
                                            v-on:click="editExists(index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status == 'in_use'" title="Կարգավիճակ"
                                            class="btn btn-sm btn-success"
                                            v-on:click="statusExists(index)">
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status == 'unnecessary'" title="Կարգավիճակ"
                                            class="btn btn-sm btn-primary"
                                            v-on:click="statusExists(index)">
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status != 'ordered'" title="Տեղափոխել"
                                            class="btn btn-sm btn-info"
                                            v-on:click="transferExist(index)">
                                        <i class="fa fa-random" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status != 'ordered'" title="Ջնջել" class="btn btn-sm btn-danger"
                                            v-on:click="deleteExists(index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                                <td v-if="userPosition.type != 'director'" style="text-align: center"
                                    class="confirm-block-control">
                                    <button v-if="items.status == 'in_use'" title="Կարգավիճակ"
                                            class="btn btn-sm btn-success"
                                            v-on:click="statusExists(index)">
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                    </button>
                                    <button v-if="items.status == 'unnecessary'" title="Կարգավիճակ"
                                            class="btn btn-sm btn-primary"
                                            v-on:click="statusExists(index)">
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                        <div v-if="openAddBlockExistsStatus" class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">
                                <div class="col-xs-4">
                                    <p v-if="oneOrderExists.status =='unnecessary'"> Նշել օգտագործվող քանակը</p>
                                    <p v-if="oneOrderExists.status =='in_use'"> Նշել չօգտագործվող քանակը</p>
                                </div>
                                <div class="col-xs-4">
                                    <label>Քանակ</label>
                                    <label class="err-r-mesage" v-if="!countValid"> Լրացրեք դաշտը</label>
                                    <input type="number" id="furniture-count-status" min="1"
                                           v-on:change="countStatusChange"
                                           class="form-control"
                                           :value="newValuesStatus.count?newValuesStatus.count:oneOrderExists?oneOrderExists.count:''">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="editExistsStatus">Պահպանել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="cancelExistStatus">
                                        Չեղարկել
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="openAddBlockExists" class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">
                                <div class="col-xs-6">
                                    <label>Անվանում</label>
                                    <label class="err-r-mesage" v-if="!nameValid"> Լրացրեք դաշտը</label>
                                    <input id="furniture-name-exists" class="form-control" v-on:keyup="nameEditChange"
                                           :value="newValuesEdit.name?newValuesEdit.name:oneOrderExists?oneOrderExists.name:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Քանակ</label>
                                    <label class="err-r-mesage" v-if="!countValid"> Լրացրեք դաշտը</label>
                                    <input type="number" id="furniture-count-exists" v-on:change="countEditChange"
                                           class="form-control"
                                           :value="newValuesEdit.count?newValuesEdit.count:oneOrderExists?oneOrderExists.count:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Բաժին</label>
                                    <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                    <select class="form-control" id="furniture-categoryStructure-exists">
                                        <option :value="oneOrderExists.categoryStructure_id" selected>
                                            {{getSchool(oneOrderExists.categoryStructure_id)}}
                                        </option>
                                        <option v-for="schoolParent in schoolsParent" :value="schoolParent">{{
                                            getSchool(schoolParent)}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label>Կատեգորիա</label>
                                    <label class="err-r-mesage" v-if="!categoryValid"> Լրացրեք դաշտը</label>
                                    <!--                                        <select v-if="oneOrder.category" id="furniture-category" class="form-control" v-model="oneOrder.category">-->
                                    <!--                                            <option value="null"></option>-->
                                    <!--                                            <option v-for="category in categories" v-bind:value="category.id">{{category.name}}</option>-->
                                    <!--                                        </select>-->
                                    <select id="furniture-category-exists" class="form-control"
                                            v-model="oneOrderExists.category_id">
                                        <option value="null"></option>
                                        <option v-for="category in categories" v-bind:value="category.id">
                                            {{category.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label>Պատասխանատու</label>
                                <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                <select class="form-control" id="furniture-user-exists"
                                        v-model="oneOrderExists.user_id">
                                    <!--                                        <option value="null"></option>-->
                                    <option v-for="username in usernames"
                                            v-if="schoolsParent.some((elem) => elem == username.categoryStructure) || user.categoryStructure_id == username.categoryStructure"
                                            :value="username.id">{{username.name}}&nbsp;&nbsp;&nbsp;&nbsp;({{
                                        getSchool(username.categoryStructure)}})
                                    </option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label>Նկարագր.</label>
                                <label class="err-r-mesage" v-if="!reasonValid"> Լրացրեք դաշտը</label>
                                <textarea v-on:keyup="reasonEditChange" id="furniture-reason-exists"
                                          style="max-width: 100%; min-width: 100%" class="form-control"
                                          :value="newValuesEdit.reason?newValuesEdit.reason:oneOrderExists?oneOrderExists.description:''"></textarea>
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="updateExists">Պահպանել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="cancelExists">
                                        Չեղարկել
                                    </button>
                                </div>
                                <div v-if="userValueValid.length>0">
                                    <p style="color:red">{{userValueValid}}</p>
                                </div>
                            </div>
                        </div>
                        <div v-if="openAddBlockExistsTransfer" class="col-xs-12 jumbotron"
                             style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0px 0px 5px 2px;">
                            <div class="col-xs-6">
                                <div class="col-xs-6">
                                    <label>Քանակ</label>
                                    <label class="err-r-mesage" v-if="!countValid"> Լրացրեք դաշտը</label>
                                    <input type="number" min="1" id="furniture-count-exists-transfer"
                                           v-on:change="countTransferChange"
                                           class="form-control"
                                           :value="newValuesTransfer.count?newValuesTransfer.count:oneOrderExists?oneOrderExists.count:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Բաժին</label>
                                    <select class="form-control" id="furniture-categoryStructure-exists-transfer">
                                        <option :value="oneOrderExists.categoryStructure_id" selected>
                                            {{getSchool(oneOrderExists.categoryStructure_id)}}
                                        </option>
                                        <option v-if="oneOrderExists.categoryStructure_id != user.categoryStructure_id"
                                                :value="oneOrderExists.categoryStructure_id">
                                            {{getSchool(user.categoryStructure_id)}}
                                        </option>
                                        <option v-for="schoolParent in schoolsParent" :value="schoolParent">
                                            {{getSchool(schoolParent)}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label>Պատասխանատու</label>
                                <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                <select class="form-control" id="furniture-user-exists-transfer">
                                    <!--                                        <option value="null"></option>-->
                                    <option value="" selected>Ընտրել պատասխանատու</option>
                                    <option v-for="username in usernames"
                                            v-if="schoolsParent.some((elem) => elem == username.categoryStructure) || user.categoryStructure_id == username.categoryStructure"
                                            :value="username.id">{{username.name}}&nbsp;&nbsp;&nbsp;&nbsp;({{getSchool(username.categoryStructure)}})
                                    </option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="updateExistsTransfer">Պահպանել
                                    </button>
                                    <button class="btn btn-danger" style="float: right"
                                            v-on:click="cancelExistsTransfer">
                                        Չեղարկել
                                    </button>
                                </div>
                                <div v-if="userValueValid.length>0">
                                    <p style="color:red">{{userValueValid}}</p>
                                </div>
                            </div>
                        </div>


                        <p style="text-align:center">
                            <v-progress-circular
                                    v-if="loading"
                                    align="center"
                                    :width="5"
                                    :size="80"
                                    color="green"
                                    indeterminate
                            ></v-progress-circular>
                        </p>


                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="text-align: center" v-if="furnitures.length>10">
                <paginate
                        v-model="page"
                        :page-count="Math.floor(furnitures.length/10+1)"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="goToPage"
                        :prev-text="'Նախորդ'"
                        :next-text="'Հաջորդ'"
                        :container-class="'pagination'"
                        :page-class="'page-item'">
                </paginate>
            </div>
        </section>
        <section v-else-if="tabIndex==1">
            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Կոդ</th>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Չօգտագործվող քանակ</th>
                                <th scope="col">Օգտագործվող քանակ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in orderData">
                                <th>{{items.code}}</th>
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category) }}</td>
                                <td>{{items.countUnnecessary}}</td>
                                <td>{{items.count}}</td>
                                <td>{{items.reason}}</td>
                                <td v-if="userPosition.type != 'director'">{{ getSchool(user.categoryStructure_id) }}
                                </td>
                                <td v-if="userPosition.type == 'director'">{{ getSchool(items.categoryStructure) }}</td>
                                <td>{{ getUsername(items.user)}}</td>
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
                                <td colspan="7"></td>
                                <td>
                                    <button v-if="!openAddBlock" v-on:click="add" style="width: 100%"
                                            class="btn btn-success pull-right">+
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                        <button v-if="!openAddBlock && orderData.length"
                                style="display: block; margin: 0 auto; text-align: center" class="btn btn-success"
                                v-on:click="sendData">Հաստատել
                        </button>
                        <p style="text-align:center">
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
                                    <label>Կոդ</label>
                                    <input id="furniture-code" class="form-control" v-on:keyup="codeChange"
                                           :value="oldvalues.code?oldvalues.code:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Անվանում</label>
                                    <label class="err-r-mesage" v-if="!nameValid"> Լրացրեք դաշտը</label>
                                    <input id="furniture-name" class="form-control" v-on:keyup="nameChange"
                                           :value="oldvalues.name?oldvalues.name:oneOrder?oneOrder.name:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Օգտագործվող քանակ</label>
                                    <label class="err-r-mesage" v-if="!countValid"> Լրացրեք դաշտը</label>
                                    <input type="number" id="furniture-count" v-on:change="countChange"
                                           class="form-control" min="1"
                                           :value="oldvalues.count?oldvalues.count:oneOrder?oneOrder.count:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Չօգտագործվող քանակ</label>
                                    <label class="err-r-mesage" v-if="!countUnnecessaryValid"> Լրացրեք դաշտը</label>
                                    <input type="number" id="furniture-count-unnecessary"
                                           v-on:change="countUnnecessaryChange"
                                           class="form-control" min="1"
                                           :value="oldvalues.countUnnecessary?oldvalues.countUnnecessary:oneOrder?oneOrder.count:''">
                                </div>
                                <div class="col-xs-6">
                                    <label>Կատեգորիա</label>
                                    <label class="err-r-mesage" v-if="!categoryValid"> Լրացրեք դաշտը</label>
                                    <!--                                        <select v-if="oneOrder.category" id="furniture-category" class="form-control" v-model="oneOrder.category">-->
                                    <!--                                            <option value="null"></option>-->
                                    <!--                                            <option v-for="category in categories" v-bind:value="category.id">{{category.name}}</option>-->
                                    <!--                                        </select>-->
                                    <select id="furniture-category" class="form-control" v-model="oneOrder.category">
                                        <option value="null"></option>
                                        <option v-for="category in categories" v-bind:value="category.id">
                                            {{category.name}}
                                        </option>
                                    </select>
                                </div>
                                <!--<div class="col-xs-6">-->
                                <!--<label>Դպրոց</label>-->
                                <!--<label class="err-r-mesage" v-if="!schoolValid"> Լրացրեք դաշտը</label>-->
                                <!--<select class="form-control" id="furniture-school"  v-model="oneOrder.school">-->
                                <!--<option value="null"></option>-->
                                <!--<option  v-for="school in schools" v-bind:value=school.id >{{school.name}}</option>-->
                                <!--</select>-->
                                <!--</div>-->
                                <div class="col-xs-6">
                                    <label>Բաժին</label>
                                    <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->
                                    <select class="form-control" id="furniture-categoryStructure">
                                        <option :value="user.categoryStructure_id" selected>
                                            {{getSchool(user.categoryStructure_id)}}
                                        </option>
                                        <option v-for="schoolParent in schoolsParent"
                                                v-if="userPosition.type == 'director'" :value="schoolParent">{{
                                            getSchool(schoolParent)}}
                                        </option>
                                    </select>
                                </div>

                                <!--                                <div class="col-xs-6">-->
                                <!--                                    <label>Կարգավիճակ</label>-->
                                <!--                                    <label class="err-r-mesage" v-if="!statusValid"> Լրացրեք դաշտը</label>-->
                                <!--                                    <select class="form-control" id="furniture-status" v-model="oneOrder.status">-->
                                <!--                                        <option value="null"></option>-->
                                <!--                                        <option value="0">Օգտագործվում է</option>-->
                                <!--                                        <option value="1">Չի Օգտագործվում</option>-->
                                <!--                                    </select>-->
                                <!--                                </div>-->

                            </div>
                            <div v-if="userPosition.type == 'director'" class="col-xs-6">
                                <label>Պատասխանատու</label>
                                <!--<label class="err-r-mesage" v-if="!userValid"> Լրացրեք դաշտը</label>-->

                                <select class="form-control" id="furniture-users" v-model="oneOrderExists.user_id">
                                    <!--                                        <option value="null"></option>-->
                                    <!--                                    <option v-if="userPosition.type != 'director'" :value="user.id" selected>{{getUsername(user.id)}}</option>-->
                                    <option v-for="username in usernames"
                                            v-if="schoolsParent.some((elem) => elem == username.categoryStructure) || user.categoryStructure_id == username.categoryStructure"
                                            :value="username.id">{{username.name}}&nbsp;&nbsp;&nbsp;&nbsp;({{
                                        getSchool(username.categoryStructure)}})
                                    </option>

                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label>Նկարագր.</label>
                                <label class="err-r-mesage" v-if="!reasonValid"> Լրացրեք դաշտը</label>
                                <textarea v-on:keyup="reasonChange" id="furniture-reason"
                                          style="max-width: 100%; min-width: 100%" class="form-control"
                                          :value="oldvalues.reason?oldvalues.reason:oneOrder?oneOrder.reason:''"></textarea>
                                <div class="confirm-block-control" style="margin-top: 3px">
                                    <button class="btn btn-success" style="float: right; margin-left: 5px"
                                            v-on:click="save">Ավելացնել
                                    </button>
                                    <button class="btn btn-danger" style="float: right" v-on:click="add">Չեղարկել
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section v-if="tabIndex==2">

            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <download-excel class="btn btn-success" :data="downloadExelMyOrderedFurn"
                                        :fields="json_fields_Furnitures"
                                        name="MyOrderedFurnList.xls">
                            Արտահանել
                        </download-excel>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Կարգավիճակ</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in myOrderedFurn">
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category_id) }}</td>
                                <td> Պատվիրված ({{ getSchool(items.ordered_from_categoryStructure_id) }})</td>
                                <td>{{items.count}}</td>
                                <td>{{items.description}}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td v-if="userPosition.type == 'director'" style="text-align: center"
                                    class="confirm-block-control">
                                    <p v-if="!items.approved">
                                        Չհաստատված
                                    </p>
                                    <div class="text-xs-center">
                                        <v-dialog
                                                v-model="items.dialog"
                                                width="316"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <button v-if="items.status == 'ordered' && items.approved"
                                                        class="btn btn-sm btn-success" v-on="on"
                                                        v-on:click="sendExists(index)">
                                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                </button>
                                            </template>

                                            <v-card>
                                                <v-card-title
                                                        class="headline grey lighten-2"
                                                        primary-title
                                                >
                                                    Տեղափոխել - {{ sendingFurn ? sendingFurn.name : '' }} ( {{
                                                    sendingFurn ? sendingFurn.count : '' }} )
                                                </v-card-title>

                                                <!--                                                <v-card-text>-->
                                                <!--                                                    <v-form v-model="valid">-->
                                                <!--                                                        <div class="container" >-->
                                                <!--                                                            <div class="row" style="display:block">-->
                                                <!--                                                                <div class="col-xs-12" style="display:block">-->
                                                <!--                                                                    <label >Քանակ</label>-->
                                                <!--                                                                    <label class="err-r-mesage" v-if="!sendCountValid && sendTouched"> Սխալ</label>-->
                                                <!--                                                                    <input style="display:block; margin-right:5px" type="number" id="furniture-count-send" v-on:change="countSendChange" :value="sendCount" class="form-control">-->
                                                <!--                                                                </div>-->
                                                <!--                                                            </div>-->
                                                <!--&lt;!&ndash;                                                            <div class="row" style="display:block" >&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                <div class="col-xs-12" style="display:block" >&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                    <label >Դպրոց</label>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                    <label class="err-r-mesage" v-if="!sendSchoolValid && sendTouched"> Լրացրեք դաշտը</label>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                    <select class="form-control" style="display:block"  id="furniture-school-send"  v-model="sendSchool">&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                        <option style="display:block"  value="null"></option>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                        <option style="display:block"  v-for="school in schools" v-bind:value=school.id >{{school.name}}</option>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                    </select>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                                </div>&ndash;&gt;-->
                                                <!--&lt;!&ndash;                                                            </div>&ndash;&gt;-->
                                                <!--                                                        </div>-->
                                                <!--                                                    </v-form>-->


                                                <!--                                                </v-card-text>-->
                                                <!--                                                <v-divider></v-divider>-->

                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                            color="danger"
                                                            flat
                                                            @click="items.dialog = false"
                                                            v-on:click="closeDialog"
                                                    >
                                                        Չեղարկել
                                                    </v-btn>
                                                    <v-btn
                                                            color="primary"
                                                            flat
                                                            v-on:click="sendFurn"
                                                    >
                                                        Հաստատել
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </div>
                                </td>
                            </tr>
                            </tbody>

                        </table>
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


                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="text-align: center" v-if="furnitures.length>10">
                <paginate
                        v-model="page"
                        :page-count="Math.floor(furnitures.length/10+1)"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="goToPage"
                        :prev-text="'Նախորդ'"
                        :next-text="'Հաջորդ'"
                        :container-class="'pagination'"
                        :page-class="'page-item'">
                </paginate>
            </div>
        </section>

        <section v-else-if="tabIndex==3">
            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <download-excel class="btn btn-success" :data="downloadExelSendedFurn"
                                        :fields="json_fields_Furnitures"
                                        name="SendedFurnList.xls">
                            Արտահանել
                        </download-excel>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Կարգավիճակ</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(items, index) in sendedFurn">
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category_id) }}</td>
                                <td>ՈՒղարկված</td>
                                <td>{{items.count}}</td>
                                <td>{{items.description}}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td style="text-align: center" class="confirm-block-control">
                                    <button class="btn btn-sm btn-success" v-on:click="confirmExists(index)">
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
        <section v-else-if="tabIndex==4">
            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <download-excel class="btn btn-success" :data="downloadExelOrderedFurn"
                                        :fields="json_fields_Furnitures"
                                        name="OrderedFurnList.xls">
                            Արտահանել
                        </download-excel>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Կատեգորիա</th>
                                <th scope="col">Կարգավիճակ</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col" style="min-width: 85px"></th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(items, index) in orderedFurn">
                                <th>{{items.name}}</th>
                                <td>{{ getCategory(items.category_id) }}</td>
                                <td>Պատվիրված</td>
                                <td>{{items.count}}</td>
                                <td>{{items.description}}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td>
                                    <p v-if="items.approved">
                                        Հաստատված
                                    </p>
                                    <p v-if="!items.approved">
                                        Չհաստատված
                                    </p>
                                </td>
                                <td style="text-align: center" class="confirm-block-control">
                                    <button class="btn btn-sm btn-danger" v-on:click="cancelOrder(index)">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <section v-else-if="tabIndex==5">

            <div class="container confirm-block">
                <div class="row">
                    <div class="col-xs-12">
                        <download-excel class="btn btn-success" :data="downloadExelShowedHistory"
                                        :fields="json_fields_showedHistory"
                                        name="ShowedHistoryList.xls">
                            Արտահանել
                        </download-excel>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Անվանում</th>
                                <th scope="col">Տիպ</th>
                                <th scope="col">Նկարագր.</th>
                                <th scope="col">Պատասխանատու</th>
                                <th scope="col">Բաժին</th>
                                <th scope="col">Պատվիրող Դպրոց</th>
                                <th scope="col">Քանակ</th>
                                <th scope="col" style="min-width: 85px"></th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(items, index) in showedHistory">
                                <th>{{items.name}}</th>
                                <td>{{ getType(items.type) }}</td>
                                <td> {{items.description}}</td>
                                <td>{{ getUsername(items.user_id)}}</td>
                                <td>{{ getSchool(items.categoryStructure_id) }}</td>
                                <td>{{
                                    getSchool(items.receiver_categoryStructure_id)?getSchool(items.receiver_categoryStructure_id):"___________"
                                    }}
                                </td>
                                <td>{{items.count}}</td>
                                <td style="text-align: center" class="confirm-block-control">
                                    {{items.created_at}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="text-align: center" v-if="historyFurn.length>10">
                <paginate
                        v-model="pageHistory"
                        :page-count="Math.floor(historyFurn.length/10+1)"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="goToPageHistory"
                        :prev-text="'Նախորդ'"
                        :next-text="'Հաջորդ'"
                        :container-class="'pagination'"
                        :page-class="'page-item'">
                </paginate>
            </div>

        </section>


    </div>


</template>
<script>

    import JsonExcel from 'vue-json-excel';

    import $ from "jquery";

    import Multiselect from 'vue-multiselect';
    import VueRangedatePicker from 'vue-rangedate-picker';
    import Paginate from 'vuejs-paginate';

    export default {
        name: "MyFurniture",
        data() {
            return {
                myOrderedFurn: [],
                historyFurn: [],
                valid: true,
                sendedFurn: [],
                orderedFurn: [],
                sendCount: 0,
                sendCountValid: false,
                sendSchool: 0,
                sendSchoolValid: false,
                sendTouched: false,
                sendingFurn: null,
                userPosition: [],
                confirmingFurniture: null,
                furnitures: [],
                tabIndex: 0,
                page: 0,
                pageHistory: 0,
                workers: [],
                user: JSON.parse(localStorage.getItem("user")),
                usernames: [],
                openAddBlock: false,
                openAddBlockExists: false,
                openAddBlockExistsStatus: false,
                openAddBlockExistsTransfer: false,
                orderData: [],
                nameValid: true,
                statusValid: true,
                userValueValid: '',
                countValid: true,
                countUnnecessaryValid: true,
                categoryValid: true,
                showedFurniture: [],
                showedHistory: [],
                updatedDataExists: {},
                newValuesStatus: {},
                newValuesEdit: {},
                newValuesTransfer: {},
                // schoolValid:true,
                reasonValid: true,
                loading: false,
                oldvalues: {},
                oneOrder: {
                    school: 'null',
                    user: 'null',
                    category: 'null',
                    // status: 'null',
                },
                oneOrderExists: {
                    school: 'null',
                    user: 'null',
                    category: 'null',
                    // status: 'null',
                },
                schools: [],
                schoolsParent: [],
                categories: [],
                downloadExelOrderedFurn: [],
                downloadExelFurniture: [],
                downloadExelMyOrderedFurn: [],
                downloadExelSendedFurn: [],
                downloadExelShowedHistory: [],
                json_fields_showedHistory: {
                    'Անվանում': 'name',
                    'Տիպ': 'type',
                    'Նկարագր': 'description',
                    'Պատասխանատու': 'responsible',
                    'Բաժին': 'categoryStructure',
                    'Պատվիրող Բաժին': 'categoryStructureOrder',
                    'Քանակ': 'count',
                    'Ամսաթիվ': 'time'
                },
                json_fields_Furnitures: {
                    'Անվանում': 'name',
                    'Կատեգորիա': 'category',
                    'Կարգավիճակ': 'status',
                    'Քանակ': 'count',
                    'Նկարագր': 'description',
                    'Բաժին': 'categoryStructure',
                    'Պատասխանատու': 'responseble'
                },
                json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ]
            }
        },

        mounted() {
            this.getUsernames();
            this.getSchools();
            this.getCategories();
            this.getWorkers();
            this.getMyFurnitures();
        },

        updated() {

        },


        components: {
            Multiselect,
            VueRangedatePicker,
            downloadExcel: JsonExcel,
            Paginate
        },


        methods: {
            getUsernames() {
                let id = this.user.position;
                var url = `auth/getUsernames/${id}`;

                axios.get(url)
                    .then((response) => {
                        this.usernames = response.data.data;
                        this.userPosition = response.data.position;
                        this.getMyFurnitures()
                    });

                // console.log(this.usernames);
            },

            getType(type) {
                switch (type) {
                    case "order":
                        return "Գրանցվել է պատվեր";
                        break;
                    case "cancel_order":
                        return "Պատվերը Չեղարկվել է";
                        break;
                    case "admin_confirm":
                        return "Ադմինը Հաստատել է";
                        break;
                    case "admin_disapprove":
                        return "Ադմինը Չղարկել է";
                        break;
                    case "admin_decline":
                        return "Ադմինը  Մերժել է";
                        break;
                    case "send":
                        return "Պատվերը ուղարկվել է";
                        break;
                    case "cancel_send":
                        return "Պատվերը մերժվել է";
                        break;
                    case "receive":
                        return "Պատվերը ստացվել է";
                        break;
                    case "cancel_receive":
                        return "Պատվերը չի ստացվել";
                        break;
                    case "add":
                        return "Գույքի Ավելացում";
                        break;
                    case "delete":
                        return "Գույքի լուծարում";
                        break;
                    case "edit":
                        return "Գույքի փոփոխություն";
                        break;
                    default:
                        return "";
                        break;
                }
            },
            goToPage(pageNum) {
                console.log("page = ", pageNum);
                this.page = pageNum;

                this.showedFurniture = this.furnitures.slice((pageNum - 1) * 10, ((pageNum - 1) * 10) + 10);
                // this.productSorting();
            },

            goToPageHistory(pageNum) {
                console.log("page = ", pageNum);
                this.pageHistory = pageNum;

                this.showedHistory = this.historyFurn.slice((pageNum - 1) * 10, ((pageNum - 1) * 10) + 10);
                // this.productSorting();
            },
            cancelOrder(index) {
                const cancelingOrder = this.orderedFurn[index];


                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: cancelingOrder};

                var url = 'auth/cancel/order/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    if (response.data.success) {
                        this.getMyFurnitures();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            getWorkers() {
                if (this.userPosition.type == 'director') {
                    let school_id = this.user.categoryStructure_id;
                    var url = '/auth/getWorkers/' + school_id;
                    axios.get(url)
                        .then((response) => {
                            this.workers = response.data.data;
                            this.getMyFurnitures()
                        });
                }
                // console.log(this.usernames);
            },
            getUsername(myid) {
                let username = null;
                let id = parseInt(myid);
                this.usernames.forEach(function (value) {
                    if (value.id == id) {
                        username = value.name;
                        return '';
                    }
                });
                return username;
            },
            edit(id) {
                this.oneOrder = {
                    name: this.orderData[id].name,
                    count: this.orderData[id].count,
                    category: this.orderData[id].category,
                    school: this.orderData[id].school,
                    reason: this.orderData[id].reason,
                    status: this.orderData[id].status,
                    user: this.orderData[id].user,
                };
                this.openAddBlock = true;
                this.remove(id);
            },

            editExists(id) {

                this.cancelExist();

                this.oneOrderExists = this.showedFurniture[id];
                this.oneOrderExists.oldIndex = id;
                this.newValuesEdit = {};
                this.openAddBlockExists = true;
                this.openAddBlockExistsTransfer = false;
                this.openAddBlockExistsStatus = false;
                this.removeExists(id);
            },
            transferExist(id) {
                this.cancelExistTransfer();
                this.oneOrderExists = this.showedFurniture[id];
                this.oneOrderExists.oldIndex = id;
                this.newValuesTransfer = {};
                this.openAddBlockExistsTransfer = true;
                this.openAddBlockExists = false;
                this.openAddBlockExistsStatus = false;
                this.removeExistsTransfer(id);
            },
            statusExists(id) {

                this.cancelExistStatus();

                this.oneOrderExists = this.showedFurniture[id];
                this.oneOrderExists.oldIndex = id;
                this.newValuesStatus = {};
                this.openAddBlockExistsStatus = true;
                this.openAddBlockExists = false;
                this.openAddBlockExistsTransfer = false;
                this.removeExistsStatus(id);
            },

            confirmExists(id) {
                this.confirmingFurniture = this.sendedFurn[id];

                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var data = {furn: this.confirmingFurniture};

                var url = 'auth/confirm/furniture';
                axios.post(
                    url,
                    data,
                ).then((response) => {
                    console.log('asd', response);
                    if (response.data.success) {
                        this.getMyFurnitures();
                    }
                })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            editExistsStatus() {

                this.loading = true;


                var count = document.getElementById('furniture-count-status');
                // var user_id = !user ? this.user.id : (user.value == 'null') ? this.user.id : user.value;
                !count.value ? this.countValid = false : this.countValid = true;
                count.value > this.oneOrderExists.count ? this.countValid = false : this.countValid = true;
                // console.log(this.oneOrderExists.count)
                // (school.value   == 'null')  ? this.schoolValid    = false:this.schoolValid      = true;
                if (this.countValid) {
                    this.updatedDataExists = {
                        count: count.value,
                    };

                    // var user = JSON.parse(localStorage.getItem("user"));
                    // if (!user) {
                    //     return false;
                    // }
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                    var data = {newData: this.updatedDataExists, oldData: this.oneOrderExists};

                    var url = 'auth/updateStatus/furniture';
                    axios.post(
                        url,
                        data,
                    )
                        .then((response) => {
                            console.log('asd', response);
                            if (response.data.success) {

                                this.getMyFurnitures();
                                this.openAddBlockExistsStatus = false;
                                this.loading = false;
                                this.newValuesStatus = {};
                            }
                        })
                        .catch((e) => {
                            console.log("exception", e);
                        });


                }
                this.loading = false;
            },
            updateExists() {

                this.loading = true;

                var name = document.getElementById('furniture-name-exists');
                var count = document.getElementById('furniture-count-exists');
                var reason = document.getElementById('furniture-reason-exists');
                // var status = document.getElementById('furniture-status-exists');
                var category = document.getElementById('furniture-category-exists');
                let categoryStructure = document.getElementById('furniture-categoryStructure-exists');
                var user = document.getElementById('furniture-user-exists');

                // var user_id = !user ? this.user.id : (user.value == 'null') ? this.user.id : user.value;


                !name.value ? this.nameValid = false : this.nameValid = true;
                !count.value ? this.countValid = false : this.countValid = true;
                // !reason.value ? this.reasonValid = false : this.reasonValid = true;

                // (school.value   == 'null')  ? this.schoolValid    = false:this.schoolValid      = true;
                (category.value == 'null') ? this.categoryValid = false : this.categoryValid = true;
                // (status.value == 'null') ? this.statusValid = false : this.statusValid = true;
                (user.value == "") ? this.userValueValid = "Լրացրեք պատասխանատու դաշտը" : this.userValueValid = "";
                if (this.nameValid && this.countValid && this.categoryValid && user.value != "") {
                    this.updatedDataExists = {
                        name: name.value,
                        count: count.value,
                        category_id: category.value,
                        description: reason.value,
                        user_id: user.value,
                        school_id: categoryStructure.value,
                    };

                    // var user = JSON.parse(localStorage.getItem("user"));
                    // if (!user) {
                    //     return false;
                    // }
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                    var data = {newData: this.updatedDataExists, oldData: this.oneOrderExists};

                    var url = 'auth/update/furniture';
                    axios.post(
                        url,
                        data,
                    )
                        .then((response) => {
                            console.log('asd', response);
                            if (response.data.success) {

                                this.getMyFurnitures();
                                this.openAddBlockExists = false;
                                this.loading = false;
                                this.newValuesEdit = {};
                            }
                        })
                        .catch((e) => {
                            console.log("exception", e);
                        });


                }
                this.loading = false;
            },
            updateExistsTransfer() {

                this.loading = true;

                var count = document.getElementById('furniture-count-exists-transfer');
                let categoryStructure = document.getElementById('furniture-categoryStructure-exists-transfer');
                var user = document.getElementById('furniture-user-exists-transfer');


                !count.value ? this.countValid = false : this.countValid = true;
                count.value > this.oneOrderExists.count ? this.countValid = false : this.countValid = true;

                (user.value == "") ? this.userValueValid = "Լրացրեք պատասխանատու դաշտը" : this.userValueValid = "";
                (user.value == this.oneOrderExists.user_id) ? this.userValueValid = "Պատասխանատու դաշտը սխալ է" : this.userValueValid = "";

                if (this.countValid && user.value != "" && user.value != this.oneOrderExists.user_id) {
                    this.updatedDataExists = {
                        count: count.value,
                        user_id: user.value,
                        school_id: categoryStructure.value,
                    };

                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                    var data = {newData: this.updatedDataExists, oldData: this.oneOrderExists};

                    var url = 'auth/updateTransfer/furniture';
                    axios.post(
                        url,
                        data,
                    )
                        .then((response) => {
                            console.log('asd', response);
                            if (response.data.success) {

                                this.getMyFurnitures();
                                this.openAddBlockExistsTransfer = false;
                                this.loading = false;
                                this.newValuesTransfer = {};
                            }
                        })
                        .catch((e) => {
                            console.log("exception", e);
                        });


                }
                this.loading = false;
            },

            deleteExists(index) {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                const furnitureId = this.showedFurniture[index].id;

                var data = {furId: furnitureId};

                var url = 'auth/delete/furniture';
                axios.post(
                    url,
                    data,
                )
                    .then((response) => {
                        console.log('asd', response);
                        if (response.data.success) {
                            // this.removeExists(index);
                            this.getMyFurnitures();
                        }
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },

            sendExists(index) {
                this.sendingFurn = this.myOrderedFurn[index];
                this.sendingFurn.oldIndex = index;
            },

            sendFurn() {

                // this.sendTouched = true;
                // this.sendSchoolValid = this.sendSchool != 0;
                // this.sendCountValid = parseInt(this.sendCount)!= 0 && parseInt(this.sendCount) <= this.sendingFurn.count;
                //
                // if(!this.sendSchoolValid || !this.sendCountValid){
                //     return;
                // }

                var user = JSON.parse(localStorage.getItem("user"));

                if (!user) {
                    return false;
                }

                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;

                var url = 'auth/send/furniture';

                const data = {
                    // sendCount: this.sendCount,
                    // sendSchoolId: this.sendSchool,
                    furniture: this.sendingFurn,
                };

                axios.post(
                    url,
                    data,
                )
                    .then((response) => {
                        if (response.data.success) {
                            this.getMyFurnitures();
                            // this.sendCount = 0;
                            // this.sendCountValid = false;
                            // this.sendSchool = 0;
                            // this.sendSchoolValid = false;
                            this.showedFurniture[this.sendingFurn.oldIndex] = false;
                            this.sendingFurn = null;
                            // this.sendTouched = false;
                        }
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });


            },

            closeDialog() {
                // this.sendTouched = false;
                // this.sendCount = 0;
                // this.sendCountValid = false;
                // this.sendSchool = 0;
                // this.sendSchoolValid = false;
                this.sendingFurn = null;
            },

            getCategory(myid) {
                let cat = null;
                let id = parseInt(myid);
                this.categories.forEach(function (value) {
                    if (value.id == id) {
                        cat = value.name;
                        return '';
                    }
                });
                return cat;
            },
            getSchool(myid) {
                let school = null;
                let id = parseInt(myid);
                this.schools.forEach(function (value) {
                    if (value.id == id) {
                        school = value.category;
                        return '';
                    }
                });
                return school;
            },
            codeChange(event) {
                this.oldvalues.code = event.target.value;
            },
            nameChange(event) {
                this.oldvalues.name = event.target.value;
            },
            nameEditChange(event) {
                this.newValuesEdit.name = event.target.value;
            },
            countChange(event) {
                this.oldvalues.count = event.target.value;
            },
            countTransferChange(event) {
                this.newValuesTransfer.count = event.target.value;
            },
            countEditChange(event) {
                this.newValuesEdit.count = event.target.value;
            },
            reasonEditChange(event) {
                this.newValuesEdit.reason = event.target.value;
            },
            countStatusChange(event) {
                this.newValuesStatus.count = event.target.value;
            },

            countUnnecessaryChange(event) {
                this.oldvalues.countUnnecessary = event.target.value;
            },

            countSendChange(event) {
                this.sendCount = event.target.value;
            },

            reasonChange(event) {
                this.oldvalues.reason = event.target.value;
            },
            sendData() {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;


                var data = this.orderData;

                var url = 'auth/add/furniture';


                axios.post(
                    url,
                    {user_id: user.id, data: data},
                )
                    .then((response) => {
                        this.furnitures = this.furnitures.concat(response.data.data);
                        const countNoShowed = 10 - this.showedFurniture.length;
                        let concatData = [];
                        // console.log(countNoShowed);
                        if (countNoShowed) {
                            response.data.data.forEach(function (item, i) {
                                // console.log(i, item);
                                if (i == countNoShowed) {
                                    return;
                                }
                                concatData.push(item);
                            });

                            if (concatData.length) {
                                this.showedFurniture = this.showedFurniture.concat(concatData);
                            }
                        }
                        this.getMyFurnitures();
                        this.orderData = [];
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },
            remove(id) {
                console.log('data:', this.orderData);
                console.log('id:', id);
                if (!id && this.openAddBlock) {
                    // this.openAddBlock = false;
                }

                this.orderData.splice(id, 1);
                console.log('data:', this.orderData);
            },
            removeExistsStatus(id) {
                this.showedFurniture.splice(id, 1);
            },
            removeExists(id) {
                this.showedFurniture.splice(id, 1);
            },
            removeExistsTransfer(id) {
                this.showedFurniture.splice(id, 1);
            },

            cancelExists() {
                this.openAddBlockExists ? this.openAddBlockExists = false : this.openAddBlockExists = true;

                const oldIndex = this.oneOrderExists.oldIndex;
                delete this.oneOrderExists.oldIndex;

                this.showedFurniture.splice(oldIndex, 0, this.oneOrderExists);
                this.oneOrderExists = {};
            },
            cancelExistsTransfer() {
                this.openAddBlockExistsTransfer ? this.openAddBlockExistsTransfer = false : this.openAddBlockExistsTransfer = true;

                const oldIndex = this.oneOrderExists.oldIndex;
                delete this.oneOrderExists.oldIndex;

                this.showedFurniture.splice(oldIndex, 0, this.oneOrderExists);
                this.oneOrderExists = {};
            },
            cancelExistStatus() {
                this.openAddBlockExistsStatus ? this.openAddBlockExistsStatus = false : this.openAddBlockExistsStatus = true;
                delete this.oneOrderExists.oldIndex;
                this.oneOrderExists = {};
            },
            cancelExist() {
                this.openAddBlockExists ? this.openAddBlockExists = false : this.openAddBlockExists = true;
                delete this.oneOrderExists.oldIndex;
                this.oneOrderExists = {};
            },
            cancelExistTransfer() {
                this.openAddBlockExistsTransfer ? this.openAddBlockExistsTransfer = false : this.openAddBlockExistsTransfer = true;
                delete this.oneOrderExists.oldIndex;
                this.oneOrderExists = {};
            },

            saveExists() {
                console.log('asda');
            },

            save() {
                this.loading = true;
                var code = document.getElementById('furniture-code');
                var name = document.getElementById('furniture-name');
                var count = document.getElementById('furniture-count');
                var countUnnecessary = document.getElementById('furniture-count-unnecessary');
                var reason = document.getElementById('furniture-reason');
                // var status = document.getElementById('furniture-status');
                var category = document.getElementById('furniture-category');
                var categoryStructure = document.getElementById('furniture-categoryStructure');
                var user = document.getElementById('furniture-users') != null ? document.getElementById('furniture-users') : this.user.id;
                // console.log(user);


                // var user_id = !user ? this.user.id : (user.value == 'null') ? this.user.id : user.value;

                // console.log('userId', user_id);
                !name.value ? this.nameValid = false : this.nameValid = true;
                (!count.value || count.value == 0) && (!countUnnecessary.value || countUnnecessary.value == 0) ? this.countValid = false : this.countValid = true;
                // count.value == 0 && countUnnecessary.value == 0 ? this.countValid = false : this.countValid = true;
                // !count.value && countUnnecessary.value == 0 ? this.countValid = false : this.countValid = true;
                // count.value == 0 && !countUnnecessary.value ? this.countValid = false : this.countValid = true;
                !reason.value ? this.reasonValid = false : this.reasonValid = true;

                // (school.value   == 'null')  ? this.schoolValid    = false:this.schoolValid      = true;
                (category.value == 'null') ? this.categoryValid = false : this.categoryValid = true;
                // (status.value == 'null') ? this.statusValid = false : this.statusValid = true;

                if (this.nameValid && this.countValid && this.categoryValid && this.reasonValid && this.statusValid) {
                    this.orderData.push({
                        code: code.value,
                        name: name.value,
                        count: count.value,
                        category: category.value,
                        reason: reason.value,
                        countUnnecessary: countUnnecessary.value,
                        // status: status.value,
                        user: user.value != null ? user.value : user,
                        categoryStructure: categoryStructure.value
                    });


                    this.oldvalues = {};
                    this.openAddBlock = false;
                    this.loading = false;
                    this.oneOrder = {
                        user: 'null',
                        category: 'null',
                        // status: 'null',
                    };

                }
                // console.log(school.value);
                // this.oldvalues = {
                //     school      : school.value,
                //     name        : name.value,
                //     count       : count.value,
                //     category    : category.value,
                //     reason      : reason.value,
                //     user        : this.user.id,
                // };
                this.loading = false;
                // }


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
                        this.getMyFurnitures();
                        for (let school of data.data) {
                            if (school.parent_category_id == this.user.categoryStructure_id) {
                                this.schoolsParent.push(school.id);
                            }
                        }
                    })
                    .catch((e) => {
                    });
            },
            getCategories() {
                var _this = this;
                var url = "/auth/getFurnitureCategories";
                axios.get(url).then(function (data) {
                    _this.categories = data.data;
                    this.getMyFurnitures()
                }).catch(function (e) {
                    console.log('exception', e);
                });
            },
            selectSchool(data) {
                this.orderData.school = data;
            },


            furnitureTabs(index) {
                this.tabIndex = index;
            },
            getStatusTranslite(status) {
                switch (status) {
                    case "in_use":
                        return "Օգտագործվում է";
                    case "unnecessary":
                        return "Չի օգտագործվում";
                    case "sended":
                        return "ՈՒղարկված";
                    case "ordered":
                        return "Պատվիրված";

                }
            },

            getMyFurnitures() {
                var user = JSON.parse(localStorage.getItem("user"));
                if (!user) {
                    return false;
                }
                var url = "auth/my/furniture";
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
                axios.post(
                    url,
                    {user_id: user.id},
                )
                    .then((response) => {

                        // _____________________________________
                        this.furnitures = response.data.data;
                        this.furnitures.reverse();
                        let arrFurnitures = [];
                        for (let x = 0; x < this.furnitures.length; x++) {
                            arrFurnitures.push({
                                name: this.furnitures[x].name,
                                category: this.getCategory(this.furnitures[x].category_id),
                                status: this.getStatusTranslite(this.furnitures[x].status),
                                count: this.furnitures[x].count,
                                description: this.furnitures[x].description,
                                categoryStructure: this.getSchool(this.furnitures[x].categoryStructure_id),
                                responseble: this.getUsername(this.furnitures[x].user_id),

                            })
                        }

                        this.downloadExelFurniture = arrFurnitures;
                        // _____________________________________
                        this.sendedFurn = response.data.sendedFurn;

                        let arrSendedFurn1 = [];
                        for (let y = 0; y < this.sendedFurn.length; y++) {
                            arrSendedFurn1.push({
                                name: this.sendedFurn[y].name,
                                category: this.getCategory(this.sendedFurn[y].category_id),
                                status: `${this.getStatusTranslite(this.sendedFurn[y].status)}`,
                                count: this.sendedFurn[y].count,
                                description: this.sendedFurn[y].description,
                                categoryStructure: this.getSchool(this.sendedFurn[y].categoryStructure_id),
                                responseble: this.getUsername(this.sendedFurn[y].user_id),

                            })
                        }


                        this.downloadExelSendedFurn = arrSendedFurn1;


                        // _____________________________________
                        this.orderedFurn = response.data.orderedFurn;
                        let arrOrderedFurn1 = [];
                        for (let z = 0; z < this.orderedFurn.length; z++) {
                            arrOrderedFurn1.push({
                                name: this.orderedFurn[z].name,
                                category: this.getCategory(this.orderedFurn[z].category_id),
                                status: `${this.getStatusTranslite(this.orderedFurn[z].status)}`,
                                count: this.orderedFurn[z].count,
                                description: this.orderedFurn[z].description,
                                categoryStructure: this.getSchool(this.orderedFurn[z].categoryStructure_id),
                                responseble: this.getUsername(this.orderedFurn[z].user_id),

                            })
                        }


                        this.downloadExelOrderedFurn = arrOrderedFurn1;

                        // _____________________________________
                        this.myOrderedFurn = response.data.myOrderedFurn;

                        let arrMyOrderFurnarr = [];
                        for (let x = 0; x < this.myOrderedFurn.length; x++) {
                            arrMyOrderFurnarr.push({
                                name: this.myOrderedFurn[x].name,
                                category: this.getCategory(this.myOrderedFurn[x].category_id),
                                status: `${this.getStatusTranslite(this.myOrderedFurn[x].status)} ${this.getSchool(this.myOrderedFurn[x].ordered_from_categoryStructure_id)}`,
                                count: this.myOrderedFurn[x].count,
                                description: this.myOrderedFurn[x].description,
                                categoryStructure: this.getSchool(this.myOrderedFurn[x].categoryStructure_id),
                                responseble: this.getUsername(this.myOrderedFurn[x].user_id),

                            })
                        }

                        this.downloadExelMyOrderedFurn = arrMyOrderFurnarr;
                        // _____________________________________
                        this.historyFurn = response.data.historyFurn;

                        let arrHistoryFurn1 = [];
                        for (let b = 0; b < this.historyFurn.length; b++) {
                            arrHistoryFurn1.push({
                                name: this.historyFurn[b].name,
                                type: this.getType(this.historyFurn[b].type),
                                description: this.historyFurn[b].description,
                                responsible: this.getUsername(this.historyFurn[b].user_id),
                                categoryStructure: this.getSchool(this.historyFurn[b].categoryStructure_id),
                                categoryStructureOrder: this.getSchool(this.historyFurn[b].receiver_categoryStructure_id),
                                count: this.historyFurn[b].count,
                                time: this.historyFurn[b].updated_at

                            })
                        }

                        this.downloadExelShowedHistory = arrHistoryFurn1;

                        // _____________________________________
                        this.goToPage(1);
                        this.goToPageHistory(1);
                    })
                    .catch((e) => {
                        console.log("exception", e);
                    });
            },


            logout() {
                this.$router.go("Login");
                this.$store.dispatch('logout');
            },
        }
    }

</script>

<style scoped>


</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
