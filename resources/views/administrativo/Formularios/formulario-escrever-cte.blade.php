@extends('administrativo.Formularios.layout')

@section('content')
<section class="section">
    <div class="div-form box" id="formulario_principal">
        <form method="POST" action="/escrever-cte" enctype="multipart/form-data" id="pdfForm">
            @csrf
            <fieldset>
                <legend id="legend"><b>ZIP</b></legend>

                <div class="div-form mb-3 form-grid">
                    <div class="div-form mb-3">
                        <label for="arquivo_zip" id="label_zip" class="form-label"><b>Importe o ZIP *<b></label>
                        <input class="form-control" type="file" id="arquivo_zip" name="arquivo_zip" accept="application/zip" required>
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