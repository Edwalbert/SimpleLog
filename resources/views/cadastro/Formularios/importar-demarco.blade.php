@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')


<link rel="stylesheet" href="{{ asset('css/Formularios/formulario-motorista.css') }}">


<section class="section">
    <form method="POST" action="/processar-excel" id="formulario_motorista" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de motorista</b></legend>
                <br>
                <div class="div-form mb-3">
                    <label for="formFile" id="label_excel" class="form-label"><b>_EXCEL "Vencimentos"</b></label>
                    <br>
                    <input type="file" id="_excel-vencimentos" name="_excel-vencimentos" accept=".xlsx" / required>
                </div>
                <br><br>
                <div class="div-form mb-3">
                    <label for="formFile" id="label_excel" class="form-label"><b>Prontuário</b></label>
                    <br>
                    <input type="file" id="prontuario" name="prontuario" accept=".xls" / required>
                </div>
                <input type="hidden" id="_excel-json" name="_excel-json">
                <input type="hidden" id="prontuario-json" name="prontuario-json">
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>
        <br><br>
    </form>
    </div>
</section>

<script>
    document.getElementById("_excel-vencimentos").addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = e.target.result;
                const workbook = XLSX.read(data, {
                    type: "array"
                });

                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const jsonData = XLSX.utils.sheet_to_json(firstSheet);
                document.getElementById("_excel-json").value = JSON.stringify(jsonData);
            };
            reader.readAsArrayBuffer(file);
        }
    });


    document.getElementById("prontuario").addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = e.target.result;
                const workbook = XLSX.read(data, {
                    type: "array"
                });

                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const jsonData = XLSX.utils.sheet_to_json(firstSheet);

                document.getElementById("prontuario-json").value = JSON.stringify(jsonData);
            };
            reader.readAsArrayBuffer(file);
        }
    });
</script>

@endsection