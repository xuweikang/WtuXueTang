import axios from 'axios';
var qs = require('qs');


var instance = axios.create({
    headers: {'content-type': 'application/x-www-form-urlencoded'}
});

let base = 'http://localhost/studyApi/PhalApi/Public/';

//export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };
export const requestLogin = params => { return instance.post(base+'?service=User.login', qs.stringify(params)).then(res => res.data); };


export const getUserList = params => { return instance.get(base+'?service=User.getUsersList', { params: params }); };

export const getUserListPage = params => { return instance.get(base+'?service=User.getUsersListPage', { params: params }); };

export const removeUser = params => { return instance.get(base+'?service=User.delUser', { params: params }); };

export const batchRemoveUser = params => { return instance.get(base+'?service=User.delUserBatch', { params: params }); };

export const editUser = params => { return instance.post(base+'?service=User.updateUser',qs.stringify(params)).then(res => res.data); };

export const addUser = params => { return instance.post(base+'?service=User.registerUser', qs.stringify(params)).then(res => res.data);; };

export const getCourseList = params => { return instance.get(base+'?service=Course.getCoursesList', { params: params }); };

export const getCourseDetail = params => { return instance.get(base+'?service=Course.selectCourseDetail', { params: params }); };

export const getCourseExmine = params => { return instance.get(base+'?service=Course.getCoursesExmine', { params: params }) };

export const removeCourse = params => {return instance.get(base+'?service=Course.removeCourse', { params: params })};

export const examineCourse = params => {return instance.get(base+'?service=Course.examineCourse',{params:params})};

export const batchExamineCourse = params =>{return instance.get(base+'?service=Course.batchExamineCourse',{params:params})};