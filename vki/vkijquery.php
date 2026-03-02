<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>AJAX ile VKİ Hesaplama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light mt-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Vücut Kitle İndeksi</h5>
                    
                    <form id="vkiFormu">
                        <div class="mb-3">
                            <label>Kilo (kg):</label>
                            <input type="number" id="kiloKutusu" name="kilo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Boy (cm):</label>
                            <input type="number" id="boyKutusu" name="boy" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Hesapla (AJAX)</button>
                    </form>

                    <div id="sonucAlani" class="alert alert-info mt-3 d-none text-center">
                        VKİ: <strong id="vkiSonuc">0</strong> <br>
                        Durum: <strong id="durumSonuc">-</strong>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#vkiFormu').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: 'hesapla.php',
        type: 'POST',
        data: $(this).serialize(), // Verileri paketle
        dataType: 'json', // JSON beklediğini söyle
        success: function(gelenVeri) {
            $('#vkiSonuc').text(gelenVeri.indeks_skoru);
            $('#durumSonuc').text(gelenVeri.saglik_durumu);
            $('#sonucAlani').removeClass('d-none');
        }
    });
});
</script>

</body>
</html>