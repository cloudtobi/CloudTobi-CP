$(document).ready(function() {

    $("#download").click(function() {
    // Überprüfen, ob alle Felder ausgefüllt sind
    if ($("#qr-text").val() == "" || $("#title-text").val() == "" || $("#description-text").val() == "") {
        alert("Bitte füllen Sie alle Felder aus!");
        return;
      }
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
        format: [297, 210]
      });

      pdf.setFontSize(15);
      pdf.text($("#title-text").val(), 100, 80);

      pdf.setFontSize(10);
      pdf.text($("#description-text").val(), 100, 100);

      let base64Image = $("#qr_code img").attr("src");
      console.log(base64Image);

      pdf.addImage(base64Image, "png", 80, 20, 40, 40);

      if ($("#pdf-option").val() === "download") {
        pdf.save("pdf.pdf");
      } else if ($("#pdf-option").val() === "new-tab") {
        var blob = pdf.output("bloburl");
        window.open(blob, "_blank");
      }
    });
  });