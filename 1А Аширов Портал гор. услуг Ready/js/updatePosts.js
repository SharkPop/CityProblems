async function getData() {
    fetch("php/getCurrentRequests.php")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Something went wrong!");
            }
            return response.json();
        })
        .then((data) => {
            for (let i = 0; i < data.length; i++) {
                var postName = document.querySelector('.updatedName' + i);
                var postCat = document.querySelector('.updatedCat' + i);
                var postDesc = document.querySelector('.updatedDesc' + i);
                var postPhoto = document.querySelector('.updatedPhoto' + i);
                var postProofPhoto = document.querySelector('.updatedProofPhoto' + i);
                postName.textContent = data[i]['name'] + " - ";
                postCat.textContent = data[i]['category'];
                postDesc.textContent = data[i]['description'];
                postPhoto.src = "img/" + data[i]['photo'];
                postProofPhoto.src = "img/" + data[i]['proofPhoto'];
            }
        })
        .catch((error) => {});
}
const interval = setInterval(getData, 5000);