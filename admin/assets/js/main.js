const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box");

toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    $(".logo-1").toggleClass("d-none");
    $(".logo-2").toggleClass("d-none");
})

let toolbaroptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'script': 'sub' }, { 'script': 'super' }],
    [{ 'indent': '-1' }, { 'indent': '+1' }],
    [{ 'direction': 'rtl' }],
    [{ 'size': ['small', false, 'large', 'huge'] }],
    ['link', 'image', 'video', 'formula'],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'font': [] }],
    [{ 'align': [] }]

];

var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: toolbaroptions
    }
});


function changeNav(id) {
    $("#" + id).addClass("nav-active");
}

$(".datatable").DataTable({});
