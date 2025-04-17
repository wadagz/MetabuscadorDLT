function formatDateToISO (date) {
    return date.toISOString().split('T')[0];
}

export { formatDateToISO };
