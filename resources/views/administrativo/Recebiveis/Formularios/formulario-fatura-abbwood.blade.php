@extends('administrativo.Formularios.layout')

@section('content')
<section class="section">
    <div class="div-form box" id="formulario_principal">
        <form method="POST" action="/fatura-abbwood" enctype="multipart/form-data" id="pdfForm">
            @csrf
            <fieldset>
                <legend id="legend"><b>CTes ABB WOOD</b></legend>

                <div class="div-form mb-3 form-grid">
                    <div class="div-form mb-3">
                        <label for="arquivo_zip_xml" id="label_zip" class="form-label"><b>Importe o ZIP de XML aqui *<b></label>
                        <input class="form-control" type="file" id="arquivo_zip_xml" name="arquivo_zip_xml" accept="application/zip" required>
                    </div>
                    <div class="div-form mb-3" style="margin-left:80px;">
                        <label for="arquivo_zip_pdf" id="label_zip" class="form-label"><b>Importe o ZIP de PDF aqui *<b></label>
                        <input class="form-control" type="file" id="arquivo_zip_pdf" name="arquivo_zip_pdf" accept="application/zip" required>
                    </div>
                    <br><br>
                    <div class="div-form mb-3">
                        <label for="observacao" id="label_zip" class="form-label"><b>Observação<b></label>
                        <input type="text" class="inputUser" id="observacao" name="observacao" maxlength="60">
                    </div>

                    <br><br>
                    <button id="visualizarPDF" class="submit">Enviar</button>
            </fieldset>
        </form>
    </div>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';
    </script>
</section>
@endsection