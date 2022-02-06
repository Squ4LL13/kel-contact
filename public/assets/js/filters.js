const searchForm = document.querySelector('form[data-trigger=search-form]');
const searchResult = document.querySelector('#search-result > ul');

searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
})

searchForm.querySelector("input").addEventListener("keyup", (e) => {
    let value = e.target.value.trim();
    if(value.length >= 3) {
        axios.get("/search/" + value)
        .then(response => {
            searchResult.innerHTML = "";
            response.data.forEach(data => {
                searchResult.innerHTML += `<li><a href="/contact/${data.id}"><i class="fas fa-angle-double-right"></i> ${data.name}</a></li>`
            })
        })
        .catch(error => {
            console.log(error);
        })
    }
    if(value.length < 3) {
        searchResult.innerHTML = "";
    }
});