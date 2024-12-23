<style>
    /* Mengatur div induk agar memiliki tinggi yang diinginkan */
    #iframe-container {
      width: 100%;
      height: 60%;  /* Anda bisa menyesuaikan tinggi div ini */
      position: relative;
    }

    /* Mengatur iframe agar mengisi seluruh div tanpa border dan scroll */
    iframe {
      width: 100%;
      height: 100%;
      border: none;
      display: block;
      overflow: hidden;
    }
  </style>

<div id="iframe-container">
    <iframe id="myIframe" src="https://smkmuhkawali.id/" onload="resizeIframe()"></iframe>
  </div>

  <script>
    function resizeIframe() {
      var iframe = document.getElementById('myIframe');
      var iframeDoc = iframe.contentWindow.document;
      
      // Pastikan iframe menyesuaikan dengan tinggi konten yang ada di dalamnya
      iframe.style.height = iframeDoc.body.scrollHeight + 'px';
    }
  </script>