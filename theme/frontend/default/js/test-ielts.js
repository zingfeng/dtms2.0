function onClickTabMenu() {
    // document.querySelector('.menu-link').classList.add('-active'); 
    document.querySelector('.menu-link').classList.toggle('-active');
}

function showQuestionsList() {
    document.querySelector('.background-questions-list').classList.toggle('-active');
}

function hideQuestionsList() {
    document.querySelector('.background-questions-list').classList.remove('-active');
}
function onClickShowNotepad(dom,id) {
	$(dom).hide();
	$("#show_note_pad_" + id).show(500);
}