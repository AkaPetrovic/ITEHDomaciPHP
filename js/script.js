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
  const el = document.getElementById("izabraniRed").children;
  for (let i = 0; i < el.length; i++) {
    if (el[i].value == trazeniRedniBroj) el[i].remove();
  }
  $("#izabraniRed").val(1);
  $("tfoot tr th:last-child").html(
    parseInt($("tfoot tr th:last-child").text()) - 1
  );
  setProperId();
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
  document.getElementById("formKreiranje").reset();
  setProperId();
}

$("#formIzmena").submit(function () {
  event.preventDefault();
  const id = $("#idIzmena").val();
  const model = $("#modelIzmena").val();
  const godiste = $("#godisteIzmena").val();

  //Getting the index of selected option in dropdown list "Proizvodjaci"
  const selectedIndexProizvodjaci =
    document.getElementById("proizvodjaciIzmena").selectedIndex;
  //Getting the text of the selected option
  const textOfSelectedOptionProizvodjaci =
    document.getElementById("proizvodjaciIzmena").children[
      selectedIndexProizvodjaci
    ].innerHTML;

  //Separating the ID of proizvodjac and Name of proizvodjac
  const proizvodjac_id = textOfSelectedOptionProizvodjaci.substring(0, 1);
  const nazivProizvodjaca = textOfSelectedOptionProizvodjaci.substring(2);
  request = $.ajax({
    url: "handler/update.php",
    type: "post",
    data: {
      id: id,
      proizvodjac_id: proizvodjac_id,
      model: model,
      godiste: godiste,
    },
  });
  request.done(function (response) {
    if (response === "Success") {
      updateViewAfterUpdate(id, nazivProizvodjaca, model, godiste);
    } else {
      alert("Izmena reda u tabeli: Neuspesna");
    }
  });
});

function updateViewAfterUpdate(id, proizvodjac, model, godiste) {
  const tableRows = document.getElementsByTagName("tbody")[0].children;
  const numberOfRows = tableRows.length;
  let content;
  for (let i = 0; i < numberOfRows; i++) {
    content = tableRows[i].children[0].innerHTML;
    if (content == id) {
      tableRows[i].children[1].innerHTML = proizvodjac;
      tableRows[i].children[2].innerHTML = model;
      tableRows[i].children[3].innerHTML = godiste;
    }
  }
  const tableRowsDropdownOptions =
    document.getElementById("izabraniRed").children;
  const numberOfOptions = tableRowsDropdownOptions.length;
  for (let i = 0; i < numberOfOptions; i++) {
    if (tableRowsDropdownOptions[i].value == id) {
      tableRowsDropdownOptions[i].innerHTML = id + " " + proizvodjac;
    }
  }
}

function setProperId() {
  const idElement = document.getElementById("id");
  const properId = parseInt($("tbody tr:last-child td:first-child").text()) + 1;
  idElement.value = properId;
}

function populateId() {
  //Getting the selected ID of the car
  const id = $("#izabraniRed").val();
  //Setting the ID to the hidden input in the form
  $("#idIzmena").val(id);
}
