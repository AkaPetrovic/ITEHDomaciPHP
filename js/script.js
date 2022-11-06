function promeniVidljivost(elements) {
  elements.forEach((element) => {
    if (element.classList.contains("hidden")) {
      element.classList.remove("hidden");
    } else {
      element.classList.add("hidden");
    }
  });
}

$("#formKreiranje").submit(function () {
  event.preventDefault();
  const form = $(this);
  const serializedData = form.serialize();
  let obj = form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
  }, {});

  const request = $.ajax({
    url: "handler/add.php",
    type: "post",
    data: serializedData,
  });

  request.done(function (response) {
    if (response === "Success") {
      updateView(obj);
    } else console.log("Autmobil nije dodat: " + response);
  });
});

function updateView(obj) {
  const nazivProizvodjaca = $("#proizvodjaci")
    .find(":selected")
    .text()
    .substring(2);
  $("tfoot tr th:last-child").html(obj.id);
  $("tbody").append(`
    <tr>
      <td>${obj.id}</td>
      <td>${nazivProizvodjaca}</td>
      <td>${obj.model}</td>
      <td>${obj.godiste}</td>
    </tr>
  `);
  promeniVidljivost([document.getElementsByClassName("message-success")[0]]);
  setTimeout(function () {
    promeniVidljivost([document.getElementsByClassName("message-success")[0]]);
  }, 5000);
}

$("#proba").on("click", function () {
  promeniVidljivost([document.getElementsByClassName("message-success")[0]]);
});
