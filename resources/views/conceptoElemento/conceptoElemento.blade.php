@extends('layouts.master')

@push('head')
    <!--link href="/css/conceptoElemento.css" type='text/css' rel='stylesheet'-->
@endpush

@section('breadcrumbs', Breadcrumbs::render('subConcepto', $concepto, $elemento))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 align-center">
                @if($elemento->id != -1)
                    <!--h1 class="center">Concepto '{{$concepto->nombre}}' con Elemento  '{{$elemento->nombre}}' </h1-->
                    <form method='GET' action='/conceptoElemento/guardar/{{$concepto->id}}/{{$elemento->id}}/{{$edit}}'>
               @else
                    <!--h1 class="center">Nuevo Subconcepto para concepto</h1-->
                    <form method='GET' action='/conceptoElemento/guardar/{{$concepto->id}}/-1/{{$edit}}'>
               @endif
                       {{ csrf_field() }}
                       <input type="hidden" name="_method" value="PUT">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="container center">
                            <div class="row">
                                <div class="col-sm-2" align="left">
                                </div>
                                <div class="col-sm-8" align="left">
                                    <div class="col-sm-12 container center">
									    <div class="row">
                                            <div class="col-sm-12 form-group required control-label" align="left">
                                                    <label for='nombreCon'>Concepto</label>
                                                    <a href="{{ URL::to('concepto/'.$concepto->id.'/'.$concepto->proyecto->id) }}" class="glyphicon glyphicon-edit"></a>
                                                    <input type='text' name='nombreCon' id='nombreCon' value='{{$concepto->nombre}}'  class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-sm-12 form-group required control-label" align="left">
                                                @if($elementoSelected!=-1)
                                                    <label for='elemento'>SubConcepto</label>
                                                    <a href="{{ URL::to('elemento/'.$elemento->id.'/'.$concepto->id)}}" class="glyphicon glyphicon-edit"></a>
                                                    <input type="hidden" name="elemento1" value="{{$elementoSelected}}">
                                                    <select name="elemento1"  class="form-control" disabled>
                                                    @foreach($elementosForDropdown as $elemento)
                                                        <option value="{{ $elemento->id }}" {{ $elemento->id == $elementoSelected ? 'selected="selected"' : '' }}>
                                                         {{$elemento->nombre}} - {{$elemento->tipo}} =  ${{$elemento->getPrecio($elemento)}}  ({{$elemento->proveedor->nombre}})
                                                        </option>
                                                    @endforeach
                                                    </select>

                                                @else
                                                    <!--label for='elemento'>Tipo</label>
                                                    <select name="tipo" id="tipo" class="form-control">
                                                        <option value="">Selecciona un tipo</option>
                                                        @ foreach($tiposForDropdown as $tipo)
                                                            <option value="{ { $tipo }}">
                                                                { { $tipo}}
                                                            </option>
                                                        @ endforeach
                                                    </select-->
                                                    <label for='elemento'>Proveedor</label>
                                                    <select name="proveedore" id="proveedore" class="form-control">
                                                        <option value="">Selecciona un proveedor</option>
                                                        @foreach($proveedoresForDropdown as $proveedore)
                                                            <option value="{{ $proveedore->id }}">
                                                                {{ $proveedore->nombre}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group required control-label" align="left">
                                                        <label for='elemento'>SubConcepto</label>
                                                        <a href="{{ URL::to('elemento/-1/'.$concepto->id)}}" class="glyphicon glyphicon-plus-sign"></a>
                                                        <select id="elemento1" class="form-control" name="elemento1" required multiple>
                                                            <option value="">Favor de Seleccionar un Proveedor primero.</option>
                                                       </select>
                                                    </div>
                                                @endif
                                                <label id="infoElemento" name='infoElemento'>{{$infoElemento}}</label>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-sm-6 form-group required control-label" align="left">
                                                <label for='precio'>Nuevo Precio o Precio al Cliente</label>
                                                <span title="Este es el precio cliente que puede ser modificado, por proyecto." class="glyphicon glyphicon-info-sign"></span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        @if($edit == 1)
                                                            <input type='number' name='precio' id='precio' step='0.01' value='{{$precio}}' class='float form-control'required>
                                                        @else
                                                            <input type="hidden" name="precio" value="{{$precio}}">
                                                            <input type='number' name='precio' id='precio' step='0.01' value='{{$precio}}' class='float form-control'disabled>
                                                        @endif
                                                    </div>

                                            </div>
                                        </div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="container center">
                            <div class="row">
                            <br>
                            </div>
                        </div>
						<div class="container center">
                            <div class="row">
                                <div class="col-sm-12 align-self-center">
                                    @if($elementoSelected!=-1)
                                        @if($edit == 1)
                                            <input type='submit' value='Actualizar Precio' class='btn btn-primary btn-small'>
                                            <a href="{{ URL::to('conceptoElemento/eliminar/'.$concepto->id.'/'.$elemento->id.'/'.$edit)}}" class="glyphicon glyphicon-trash"></a>
                                        @else
                                            <input type='submit' value='Actualizar Precio' class='btn btn-primary btn-small' disabled>
                                        @endif
                                    @else
                                        <input type='submit' value='Agregar Elemento a Concepto' class='btn btn-primary btn-small'>
                                    @endif
                                </div>
                            </div>
                        </div>

               </form>
			</div>
		</div>
    </div>
    <script>
        $('#proveedore').on('change', function(e){
            console.log(e);
            var proveedore_id = e.target.value;
            //window.alert("sometext-" + proveedore_id);

            $.get('{{ url('information') }}/create/ajax-proveedoresElemento/' + proveedore_id, function(data) {
                console.log(data);
                $('#infoElemento').text("");
                $('#elemento1').empty();
                //$('#elemento1').append('<option value=\"\"> - </option>');
                $.each(data, function(index,subCatObj){
                    //window.alert("sometext2-" + subCatObj.nombre);

                    $('#elemento1').append('<option value=\"'+subCatObj.id+'\">'+subCatObj.nombre+" - "+subCatObj.tipo+' = $'+ subCatObj.precio+'</option>');
                });
            });
        });
        $('#elemento1').on('change', function(e){
            console.log(e);
            var elemento_id = e.target.value;
            //window.alert("elemento1-" + elemento_id);

            $.get('{{ url('information') }}/create/ajax-elementoCostoGanancia/' + elemento_id, function(data) {
                //window.alert("elemento1-" + elemento_id);
                console.log(data);
                $('#infoElemento').text(data);
            });
        });
    </script>
@endsection

