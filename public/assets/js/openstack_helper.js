/**
 * Created by takahiro on 14/12/09.
 */


var openstack_helper = {
    fetchServerList: function(){

    },
    check_instance: function(server_id){
        var send_data = {
            component:  'nova',
            path:       '/servers/'+server_id,
            method:     'get',
            data:       ""
        };
        return $.ajax({
            url: '/openstack/send_request.json',
            type: 'post',
            dataType:'json',
            data: JSON.stringify(send_data)
        });
    },
    create_instance: function(name, user_id, course_id){
    var imageRef    = "b0d4c4c6-d22d-4cc9-8b56-7b1c4897c494";
    var flavorRef   = "fed212c2-7226-47af-b19b-4b43f2060539";
    var data = {
        server: {
            name: name,
            imageRef: imageRef,
            flavorRef: flavorRef,
            max_count: 1,
            min_count: 1,
            networks: [
                {uuid: '00a04ab7-265f-41cb-a798-7294be3d4b14'}
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