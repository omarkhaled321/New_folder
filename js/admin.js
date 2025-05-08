function deleteClass(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "deleteapplications.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = xhr.responseText;
            if (response === "Success") {
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.remove();
                }
            } else {
                alert(response);
            }
        }
    };
    xhr.send(`id=${id}`);
}


// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
