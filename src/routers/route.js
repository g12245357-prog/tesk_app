import { createNativeStackNavigator } from "@react-navigation/native-stack";


export default function Router(){

    const Stack = createNativeStackNavigator();

    return(

        <Stack.Navigator initialRouteName="Splash">
            <Stack.Screen  name="Splash" component={Splash} />
            <Stack.Screen  name="Login" component={Login} />
            <Stack.Screen  name="Home" component={Home} />
            <Stack.Screen  name="Cadastro_User" component={Cadastro_User} />
            <Stack.Screen  name="Tarefas" component={Tarefas} />
            <Stack.Screen  name="Edita_Tarefa" component={Edita_Tarefa} />
        </Stack.Navigator>


    )
}