function promeniVidljivost(elements) {
  elements.forEach((element) => {
    if (element.classList.contains("hidden")) {
      element.classList.remove("hidden");
    } else {
      element.classList.add("hidden");
    }
  });
}

$("#izbrisiRed").on("click", function () {
  request = $.ajax({
    url: "handler/delete.php",
    type: "post",
    data: { id: $("#izabraniRed").val() },
  });
  request.done(function (response) {
    if (response === "Success") {
      updateViewAfterRemove();
      alert("Red u tabeli je uspesno obrisan");
    } else {
      alert("Brisanje reda u tabeli: Neuspesno");
    }
  });
});

function updateViewAfterRemove() {
  const trazeniRedniBroj = $("#izabraniRed").val();
  const length = document.getElementsByTagName("tbody")[0].children.length;
  const collection = document.getElementsByTagName("tbody")[0].children;
  let content;
  for (let i = 0; i < length; i++) {
    content = collection[i].children[0].innerHTML;
    if (trazeniRedniBroj == content) {
      collection[i].remove();
      break;
    }
  }
  const vrednost = document.getElementById("izabraniRed").value;
  const el = document.getElementById("izabraniRed").children;
  for (let i = 0; i < el.length; i++) {
    if (el[i].value == vrednost) el[i].remove();
  }
  $("#izabraniRed").val(1);
  $("tfoot tr th:last-child").html(
    parseInt($("tfoot tr th:last-child").text()) - 1
  );
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
      updateViewAfterAdd(obj);
    } else console.log("Autmobil nije dodat: " + response);
  });
});

function updateViewAfterAdd(obj) {
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
  $("#izabraniRed").append(`
    <option value="${obj.id}">${obj.id} ${nazivProizvodjaca}</option>
  `);
  // promeniVidljivost([document.getElementsByClassName("message-success")[0]]);
  // setTimeout(function () {
  //   promeniVidljivost([document.getElementsByClassName("message-success")[0]]);
  // }, 5000);
  document.getElementById("formKreiranje").reset();
  setProperId();
}

function setProperId() {
  const idElement = document.getElementById("id");
  const properId = parseInt($("tbody tr:last-child td:first-child").text()) + 1;
  idElement.value = properId;
}

$("#proba").on("click", function () {
  console.log(parseInt($("tfoot tr th:last-child").text()));
});
