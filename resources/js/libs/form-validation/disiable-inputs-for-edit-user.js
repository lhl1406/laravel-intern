const setReadonlyForInputForEdit = function (positionId, routeName) {
    let arrayRouteName = routeName.split('.');
    let action = arrayRouteName[arrayRouteName.length - 1];

    if(positionId != 0 && action === 'edit') {
        const elements = [
            'id',
            'name',
            'email',
            'group_id',
            'started_date',
            'position_id',
        ]

        const elementsNotBlockedPoiterEvent = [
            'name',
        ]

        $.each(elements, function(i, element) {
            $(`#user-add-edit-delete-form [name=${element}]`).attr('readonly', 'true');

            if(! elementsNotBlockedPoiterEvent.includes(element)) {
                $(`#user-add-edit-delete-form [name=${element}]`).css('pointer-events', 'none');
            }
        })
    }
}  