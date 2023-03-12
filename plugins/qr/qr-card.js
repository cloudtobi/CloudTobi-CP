$(document).ready(function() {

    $("#download").click(function() {
      var qrcode = new QRCode("qr_code", {
        text: $("#qr-text").val(),
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });

      var pdf = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [84, 40]
      });

      pdf.setFontSize(15);
      pdf.text($("#title-text").val(), 43, 20);

      pdf.setFontSize(10);
      pdf.text($("#description-text").val(), 43, 25);

      let base64Image = $("#qr_code img").attr("src");
      console.log(base64Image);

      pdf.addImage(base64Image, "png", 0, 0, 40, 40);

      if ($("#pdf-option").val() === "download") {
        pdf.save("generated.pdf");
      } else if ($("#pdf-option").val() === "new-tab") {
        var blob = pdf.output("bloburl");
        window.open(blob, "_blank");
      }
    });
  });