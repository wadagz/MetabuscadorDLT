function formatDateToISO (date) {
    return date.toISOString().split('T')[0];
}

function formatDateTimeString (dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toISOString().split('T')[0];
}

export { formatDateToISO, formatDateTimeString };
