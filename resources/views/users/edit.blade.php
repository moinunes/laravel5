
@extends('layouts.layout_main')
@section('content')



    @if($errors->any())
      <ul class="alert alert-danger"> 
         @foreach($errors->all() as $error)
               <li>{{$error}}</li>
         @endforeach
      </ul>
  
     @endif

     
     <div class="well body-hight">
        
         
         @if( $acao == 'C' )           
           {!! Form::model( $table, ['route' => 'table.index', 'class'=>'form-signup form-paddind' ] ) !!}
         @else
            {!! Form::model($table,['method'=>'PATCH','action'=>['ProdutoController@update',$table->id],'class'=>'form-signup form-paddind']) !!}
         @endif

         <div class="form-group">
<input name="acao" type="hidden" value="{{$acao}}">
             {!! Form::text('name',null,['class'=>'form-control from-width','placeholder'=>'name']) !!}

         </div>
         <div class="form-group">

             {!! Form::text('email',null,['class'=>'form-control from-width','placeholder'=>'email']) !!}

         </div>

         <div class="form-group">

             {!! Form::text('job',null,['class'=>'form-control from-width','placeholder'=>'job']) !!}

         </div>
         <div class="form-group">

             {!! Form::text('salary',null,['class'=>'form-control from-width','placeholder'=>'salary']) !!}

         </div>

         <div class="form-group">

             
          @if ( $acao == 'C' )                  
             <a href="/table/" class="btn btn-default">Voltar</a>
          @else
             <a href="/table/" class="btn btn-default">Cancelar</a>
             <button type="submit" class="btn btn-success">Confirmar</button>                     
          @endif

         </div>

         {!! Form::close() !!}

     </div>


@stop