@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Gerador de Carnês</h1>
        <form action="{{ url('/store') }}" method="post" target="_blank">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-12">
                    <select name="loja" class="custom-select" required="required">
                        <option value="">Selecione um estabelecimento</option>
                        @foreach(lojas() as $c => $loja)
                            <option value="{{$c}}">{{ $loja }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-10">
                    <input type="text" class="form-control" name="nome" id="nome" required
                           placeholder="Nome do Cliente">
                </div>
                <div class="form-group col-2">
                    <input type="text" class="form-control" name="numero_nota" id="numero_nota"
                           placeholder="Nº da Nota">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-4">
                    <input type="text" class="form-control" name="vendedor" id="vendedor"
                           placeholder="Nome do Vendedor">
                </div>
                <div class="form-group col-8">
                    <input type="text" class="form-control" name="observacoes" id="observacoes"
                           placeholder="Observações">
                </div>
            </div>


            <div class="form-row">
                <div class="col-6">
                    <h3>Parcelas</h3>
                </div>
                <div class="col-6">
                    <div class="form-group float-right">
                        <a href="#" class="btn btn-primary add_parcela"><i class="fa fa-plus"></i> Adicionar</a>
                    </div>
                </div>
            </div>

            <div id="parcelas">
                <div class="form-row">
                    <div class="form-group col-2">
                        <input type="text" class="form-control data" id="vencimento" required name="vencimento[]"
                               placeholder="Vencimento">
                    </div>
                    <div class="form-group col-2">
                        <input type="text" class="form-control valor" id="valor" required name="valor[]"
                               placeholder="Valor Parcela">
                    </div>
                    <div class="form-group col-1">
                        <a href="#" class="btn btn-danger btn-block remove_parcela"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane-o"></i> Enviar</button>
        </form>
    </div>
@endsection
