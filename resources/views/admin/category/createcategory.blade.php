@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить категорию
                <small>приятные слова..</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

        {!! Form::open(['route' => 'categories.store']) !!}
        <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавляем категорию</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Статус</label>
                            <select class="form-control" name="status">
                                <option >Active</option>
                                <option >Passive</option>
                            </select>
                            <label for="catname">Название</label>
                            <input name="cat_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                            <label for="catdesc">Описание</label>
                            <textarea class="form-control" name="cat_desc" cols="50" rows="10" id="placeOfDeath"></textarea>
                            <label for="catslug">Slug</label>
                            <input name="cat_slug" type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                            <label for="catparent">Подкатегория</label>
                            <select class="form-control" name="parent">
                                <option value=""></option>
                                @foreach($categories as $pod)
                                    <option >{{$pod->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button class="btn btn-success pull-right">Добавить</button>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            {!! Form::close() !!}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection