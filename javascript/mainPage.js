let users = [];
let imageData = '';

const handleImageData = async (event) => {
    let img = new Image;
    const canvas = document.createElement('canvas');

    const maxW = 500;
    const maxH = 500;

    img.onload = () => {
        const scale = Math.min((maxW / img.width), (maxH / img.height));
        const imageWidthScaled = img.width * scale;
        const imageHeightScaled = img.height * scale;

        canvas.width = imageWidthScaled;
        canvas.height = imageHeightScaled;
        canvas.getContext('2d').drawImage(img, 0, 0, imageWidthScaled, imageHeightScaled);

        const encodedImage = canvas.toDataURL("image/jpeg", 0.5);
        document.getElementById('avatar').innerHTML = `<img alt="avatar" id="avatar-image" src="${encodedImage}" class="w-full h-full rounded" />`;
        imageData = encodedImage.replace('data:image/jpeg;base64,', '');
    }

    img.src = URL.createObjectURL(event.target.files[0]);
};

window.onload = () => {
    const image = document.getElementById("image");
    image.addEventListener("change", (e) => handleImageData(e));
};
const registerUser = async () => {
    let formData = new FormData();
    formData.set('name', document.getElementById("name").value ?? null);
    formData.set('email', document.getElementById("email").value ?? null);
    formData.set('consent', document.getElementById("consent").checked ?? null);
    formData.set('imageData', imageData ?? null);

    const response = await fetch('api.php/register',
        {
            method: 'POST',
            body: formData
        }
    )
    const responseData = JSON.parse(await response.text());

    if (response.status === 200) {
        if (responseData.success) {
            alert("User added!");
            document.getElementById('user-form').reset();
            document.getElementById('avatar-image').remove();
        } else {
            alert(responseData.data.message);
        }
    } else {
        alert(responseData);
    }
}