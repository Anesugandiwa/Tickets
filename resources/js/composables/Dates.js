import moment from "moment";

export function displayDate(date){

    const DMY = moment(date).format('DD-MMM-YYYY')
    const YMD = moment(date).format('YYYY-MMM-DD')
    const daymY = moment(date).format('d-MM-YYYY')

    return { DMY, YMD , daymY} ;

}
