function formatPrice(value) {
    if (value === null || value === undefined) return ''
    const number = new Intl.NumberFormat('es-MX', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value)

    return '$' + number + ' MXN'
};

// Format number to MXN currency
const formatCurrency = (value) => {
    if (value === null || value === undefined) return ''
    return new Intl.NumberFormat('es-MX', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value)
}

// Remove currency symbols and commas so InputNumber can parse back to a number
const parseCurrency = (input) => {
    if (typeof input === 'string') {
        return Number(input.replace(/[^0-9.-]+/g, ''))
    }
    return input
}

export { formatPrice, parseCurrency, formatCurrency };
