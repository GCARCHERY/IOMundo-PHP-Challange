const ITEMS_ON_PAGE = 5;

let maxPages = 1;
let currentPage = 1;
let users = [];
const getUsers = async () => {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    const params = {
        ...name.length > 0 ? {'name' : name} : undefined,
        ...email.length > 0 ? {'email' : email} : undefined,
    };

    const url = 'api.php/users?' + new URLSearchParams(params);

    const response = await fetch(url, {
        method: 'GET',
    });

    if (response.status === 200) {
        users = JSON.parse(await response.text()).data.users;
        maxPages = Math.ceil(users.length / ITEMS_ON_PAGE);
        handlePaginationControls(maxPages);
        displayUsers(1);
    }
}

window.onload = () => getUsers();

const handlePaginationControls = (numberOfPages) => {
    let pageButtons = '';
    for (let i = 0; i < numberOfPages; i++) {
        pageButtons += `
            <button 
                onclick="displayUsers(${i + 1})"
                class="bg-purple-500 hover:bg-purple-700 text-white font-bold my-2 py-2 px-2 mx-1 border border-purple-700 rounded"
            >
                <h2>${i + 1}</h2>
            </input>`;
    }
    document.getElementById('pagination-items').innerHTML = pageButtons;
}
const displayUsers = (page) => {
    const startIndex = (page - 1) * ITEMS_ON_PAGE;
    document.getElementById('user-container').innerHTML = users.slice(startIndex, startIndex + ITEMS_ON_PAGE)
        .map(user =>
            `<div class="w-1/3 flex flex-col items-center bg-purple-300 mb-2.5 rounded">
                <div>Id: ${user.id}</div>
                <div>Name: ${user.name}</div>
                <div>Email: ${user.email}</div>
                <img alt="avatar" src="data:image/jpeg;base64,${user.user_image}" class="rounded aspect-1 w-1/3 pb-2.5" />
             </div>`
    ).join('');
}
const exportToCSV = () => {
    let csvContent = "data:text/csv;charset=utf-8,-,name,email,Base64 Image Data\n" + users.map(e => Object.values(e).join(",")).join("\n");
    window.open(encodeURI(csvContent));
}