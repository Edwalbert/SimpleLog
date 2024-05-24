@extends('administrativo.Formularios.layout')

@section('content')

<section class="section">
    <form method="POST" action="/cadastro-clientes-resumido" enctype="multipart/form-data">
        @csrf
        <div class="div-form" id="formulario_principal">
            <fieldset class="box">
                <legend id="legend"><b>Cadastro de CLientes (Resumido)</b></legend>
                <br>
                <input type="hidden" name="id_retirada" id="id_retirada" class="inputUser">

                <div class="div-form inputBox">
                    <input type="text" name="razao_social" id="razao_social" class="inputUser" maxlength="100" required>
                    <label for="razao_social" class="labelInput">Cliente</label>
                </div>
                <br><br><br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>

    </form>
</section>

@endsection