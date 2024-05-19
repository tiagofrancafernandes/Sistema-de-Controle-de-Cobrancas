export const toTitle = (text) => {
    if (!text || typeof text !== 'string') {
      return '';
    }

    text = text.replaceAll(/  /gi, '');
    for (let char of ['-', '.', '_', ',', '"', '  ']) {
        char = (char === '.') ? '\\' + char : char;
        char = (char.trim() === '') ? ' ' : char;
        text = text.replaceAll(new RegExp(`${char}`, 'ig'), ' ').trim();
    }

    text = text.replaceAll(/  /gi, ' ');

    // Divide a string em words
    let words = text.toLowerCase().split(' ');

    // Converte a primeira letra de cada palavra em maiúscula
    for (let i = 0; i < words.length; i++) {
      words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
    }

    // Junta as words em uma única string

    return words.join(' ');
}
