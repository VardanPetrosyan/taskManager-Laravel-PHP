@extends('_layouts.admin')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить Продукт

            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <form action="{{ route('admin_products_insert') }}" enctype="multipart/form-data" method="post">
                    @csrf
                @include('admin.errors')
                <div class="box-header with-border">
                    <h3 class="box-title">Добавляем Продукт</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="">
                        </div>


                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" class="form-control select2" style="width: 100%;">
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>

                        <!-- Date -->

                        <div class="form-group">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" value="" class="form-control" id="exampleInputEmail1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Count</label>
                            <input type="text" name="count" class="form-control" id="exampleInputEmail1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Upload </label>
                            <span id="fileselector">
                                <label class="btn btn-default" for="upload-file-selector">
                                    <input id="upload-file-selector" name="image" type="file">
                                    <i class="fa_icon icon-upload-alt margin-correction"></i>upload file
                                </label>
                            </span>
                        </div>
                        <!-- checkbox -->

                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea  name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button  class="btn btn-success pull-right">Add Product</button>
                </div>
                <!-- /.box-footer-->
                </form>
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    @endsection