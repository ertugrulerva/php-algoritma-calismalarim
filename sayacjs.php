<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Canlı Karakter Sayacı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light mt-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <div class="card shadow">
                    <div class="card-body">
                        <h5>Yorumunuzu Yazın</h5>
                        
                        <textarea id="mesajKutusu" class="form-control" rows="4" placeholder="Neler düşünüyorsunuz?"></textarea>
                        
                        <div class="mt-2 text-end text-muted">
                            <span id="sayacRakam" class="fw-bold">0</span> / 100 Karakter
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

<script>
  const kutu=document.getElementById("mesajKutusu");
  const rakamAlani=document.getElementById("sayacRakam");
  const sinir=100;
    kutu.addEventListener("input",function(){
        let yazilanHarfSayisi=kutu.value.length;
        rakamAlani.textContent=yazilanHarfSayisi;
    
        if(yazilanHarfSayisi>sinir)
        {
            rakamAlani.classList.add("text-danger");
        }
        else
        {
            rakamAlani.classList.remove("text-danger");
        }                   
        });
</script>

</body>
</html>