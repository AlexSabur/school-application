export const numberCharExtracter = (name) => {
    const regex = /(?<number>\d*)(?<charter>\W*)/ug;
    const match = regex.exec(name);

    return [parseInt(match.groups.number, 10), String(match.groups.charter)];
}
