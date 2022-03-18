function pagination(totalPages, page, webpage) {
    const ulTag = document.getElementById("pagin");
    let liTag = '';
    let beforePages = page - 1;
    let afterPages = page + 1;
    let activeLi;
    if (page > 1) {
        liTag += `<li class="btn prev" onclick="location.href='./${webpage}.php?page=${beforePages}'"><span><i class="fas fa-angle-left"></i>Prev</span></li>`;
    }
    if (page > 2) {
        liTag += `<li class="numb "  onclick="location.href='./${webpage}.php?page=1'"><span>1</span></li>`;
        if (page > 3) {
            liTag += `<li class="dot"><span>...</span></li>`;
        }
    }

    for (let pageLength = Math.max(1, beforePages); pageLength <= Math.min(totalPages, afterPages); pageLength++) {
        if (pageLength == page) {
            activeLi = "active";
        }
        liTag += `<li class="numb ${activeLi}" onclick="location.href='./${webpage}.php?page=${pageLength}'"><span>${pageLength}</span></li>`;
        activeLi = "";
    }

    if (page < totalPages - 1) {
        if (page < totalPages - 2) {
            liTag += `<li class="dot"><span>...</span></li>`;
        }
        liTag += `<li class="numb" onclick="location.href='./${webpage}.php?page=${totalPages}'"><span>${totalPages}</span></li>`;
    }
    if (page < totalPages) {
        liTag += `<li class="btn next" onclick="location.href='./${webpage}.php?page=${afterPages}'"><span>Next<i class="fas fa-angle-right"></i></span></li>`;
    }
    ulTag.innerHTML = liTag;
}