/**
 * Created by takahiro on 14/12/09.
 */


var openstack_helper = {
    fetchServerList: function(){

    },
    create_instance: function(name, user_id, course_id){
    var imageRef    = "02803367-771e-4c39-9a13-bbffb530f65f";
    var flavorRef   = "2b128dfd-349f-4027-900f-8a2cea977828";
    var data = {
        server: {
            name: name,
            imageRef: imageRef,
            flavorRef: flavorRef,
            max_count: 1,
            min_count: 1,
            networks: [
                {uuid: '780a30bd-9638-46ab-b349-055301973fc9'}
            ],
            security_groups:[
                {name: 'default'}
            ]
        }
    };
    var sendData =  {
        component: "nova",
        path: "/servers",
        method: "post",
        data: data
    };

    return $.ajax({
        url: '/openstack/send_request.json',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify(sendData)

    }).done(function(data){
        //save
        if(data.server != null){//成功
            var data = {
                user_id: user_id,
                course_id: course_id,
                server_id: data.server.id
            };
            $.ajax({
                url: '/api/course/add_server.json',
                type: 'post',
                data: JSON.stringify(data)
            }).done(function(data){
                if(data == 1){
                    //ok
                }
            });
        }else{
            //error
        }
    });
}
};