var FormEventer = function(){
    return webix.ui({
        container:"productMasterForm",
        cols:[
            {
                view:"form",
                elements:[
                    { view:"text", label:"Title" },

                ]
            }
        ]
    });
};