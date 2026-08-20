Alpine.store("editItem", {
    item: {},
    update(t) {
        this.item = t
    }
});
Alpine.store("reportItem", {
    id: {},
    update(t) {
        this.id = t,
        document.getElementById("report_id").value = t,
        document.getElementById("report_id").dispatchEvent(new Event("input"))
    }
});
Alpine.bind("exportExcel", () => ({
    type: "button",
    "@click"(t) {
        const e = t.target.getAttribute("data-id");
        e && a(e)
    }
}));
Alpine.bind("buyItem", () => ({
    type: "button",
    "@click"(t) {
        const e = t.target.getAttribute("data-id");
        document.getElementById("itemBuyId").value = e,
        document.getElementById("itemBuyId").dispatchEvent(new Event("input")),
        document.getElementById("accNumber").innerText = e;
        const n = new CustomEvent("showModal",{
            detail: {
                modalId: "confirmBuy"
            }
        });
        window.dispatchEvent(n)
    }
}));
Alpine.bind("detailItem", () => ({
    type: "button",
    "@click"(t) {
        t.target.getAttribute("data-id")
    }
}));
Alpine.bind("preBuyItem", () => ({
    type: "button",
    "@click"(t) {
        const e = t.target.getAttribute("data-id");
        document.getElementById("itemBuyPreId").value = e,
        document.getElementById("itemBuyPreId").dispatchEvent(new Event("input")),
        document.getElementById("accNumberPre").innerText = e;
        const n = new CustomEvent("showModal",{
            detail: {
                modalId: "confirmBuyOrder"
            }
        });
        window.dispatchEvent(n)
    }
}));
Alpine.bind("detailItemPre", () => ({
    type: "button",
    "@click"(t) {
        const e = t.target.getAttribute("data-id");
        document.getElementById("accNumberDetailPre").innerText = e,
        document.getElementById("roboxDetailPre").innerText = t.target.getAttribute("data-robox"),
        document.getElementById("rateDetailPre").innerText = t.target.getAttribute("data-rate"),
        document.getElementById("priceDetailPre").innerText = t.target.getAttribute("data-price"),
        document.getElementById("guaranteeDetailPre").innerText = t.target.getAttribute("data-guarantee"),
        document.getElementById("btnBuyModelPre").setAttribute("data-id", e)
    }
}));
function a(t) {
    const e = document.getElementById(t)
      , n = XLSX.utils.book_new()
      , d = XLSX.utils.aoa_to_sheet([["SELLROBUX.COM SHOP MUA BÁN ACC ROBUX GIÁ RẺ"]])
      , i = XLSX.utils.table_to_sheet(e);
    XLSX.utils.sheet_add_json(d, XLSX.utils.sheet_to_json(i), {
        origin: -1
    }),
    XLSX.utils.book_append_sheet(n, d, "Sheet1"),
    XLSX.writeFile(n, "SELLROBUX.COM SHOP MUA BÁN ACC ROBUX GIÁ RẺ.xlsx")
}
