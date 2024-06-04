const changeButton = document.querySelector("#ChangeBtn");
const changeImageSelector = document.querySelector("#ChangeProfileImage");
const exitSelectorButton = document.querySelector("#PrzyciskWylaczajacyMenuProfile");
const editorImage = document.querySelector("#editorImg");

const showContent = () => {
    changeImageSelector.style.display = "grid";
};

const hideContent = () => {
    changeImageSelector.style.display = "none";
}

const setProfileImage = id => {
    imageId.value = id;
    editorImage.src = `img/ProfileImages/${id}.jpg`;
    hideContent();

    if(userProfileImage != imageId.value) 
        saveButton.style.display = "block";
    else 
        saveButton.style.display = "none";
}

changeButton.addEventListener("click", showContent);
exitSelectorButton.addEventListener("click", hideContent);