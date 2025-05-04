const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

function formatDateToISO (date) {
    return date.toISOString().split('T')[0];
}

function formatDateTimeString (dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toISOString().split('T')[0];
}

function getWeekDayFromNumber(numero) {
  return diasSemana[numero] || 'Número inválido';
}

export { formatDateToISO, formatDateTimeString, getWeekDayFromNumber };
