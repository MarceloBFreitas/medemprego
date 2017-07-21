<div class="container" style="background: #fff;">
    <label for="">Digite o Número do Cartão</label>
    <input type="text" class="form-control" id="numcartao" placeholder="Campo não tratado, digite sem espaço ex: 444111111111"><br>
    <br>
    <label for="">Digite Dígito Verificador</label>
    <input type="text" class="form-control"  id="cvv" placeholder="ex: 562"><br>

    <br>
    <label for="">Mês Expiração</label>
    <input type="text" class="form-control"  id="validadeMes" placeholder="04 = Abril"><br>

    <br>
    <label for="">Ano Expiração</label>
    <input type="text" class="form-control"  id="validadeAno" placeholder="17 = 2017"><br>

    <br>
    <label for="">Nome no Cartão</label>
    <input type="text" class="form-control"  id="nomecartao" ><br>

    <br>
    <label for="">CPF</label>
    <input type="text" class="form-control"  id="cpfcartao" ><br>

    <br>
    <label for="">Data Nascimento</label>
    <input type="text" class="form-control"  placeholder="ex: 01/04/1985" id="datanascimentocartao" ><br>

    <br>
    <label for="">E-Mail Válido</label>
    <input type="text" class="form-control"  id="emailcomprador" ><br>

    <br>
    <label for="">Rua</label>
    <input type="text" class="form-control"  id="ruacomprador" ><br>

    <br>
    <label for="">Número</label>
    <input type="text" class="form-control"  id="numcomprador" ><br>
 <br>
    <label for="">Bairro</label>
    <input type="text" class="form-control"  id="bairrocomprador" ><br>

    <br>
    <label for="">Cidade</label>
    <input type="text" class="form-control"  id="cidadecomprador" ><br>

    <br>
    <label for="">Estado</label>
    <input type="text" class="form-control" placeholder="ex: SP" id="estadocomprador" ><br>

    <br>
    <label for="">ddd</label>
    <input type="text" class="form-control"  id="dddcomprador" ><br>

    <br>
    <label for="">telefone</label>
    <input type="text" class="form-control"  id="telefonecomprador" ><br>

    <br>
    <label for="">CEP</label>
    <input type="text" class="form-control"  id="cepcomprador" placeholder="ex: 19470000" ><br>

    <button class="btn btn-success" onclick="iniciaAssinatura()">Assinar</button>
    <button class="btn btn-success" onclick="preenchercampos()">Preencher campos, menos Cartão</button>

</div>
<script type="application/javascript">
    function preenchercampos(){
        $('#cpfcartao').val(localStorage.getItem('cpf'));
        $('#nomecartao').val(localStorage.getItem('nomecartao'));
        $('#datanascimentocartao').val(localStorage.getItem('datanascimento'));
        $('#emailcomprador').val(localStorage.getItem('email'));
        $('#ruacomprador').val(localStorage.getItem('rua'));
        $('#cidadecomprador').val(localStorage.getItem('cidade'));
        $('#bairrocomprador').val(localStorage.getItem('bairro'));
        $('#estadocomprador').val(localStorage.getItem('estado'));
        $('#dddcomprador').val(localStorage.getItem('ddd'));
        $('#telefonecomprador').val(localStorage.getItem('telefone'));
        $('#numcomprador').val(localStorage.getItem('numero'));
        $('#cepcomprador').val(localStorage.getItem('cep'));

    }

    function iniciaAssinatura(){
        $.ajax({
            url: 'validar/criasessaorecorrente.php',
            type: 'post',
            async: false,
            dataType: 'html',
            data: {
                'campo':"campo"
            }
        }).done(function(data){
            var $idSessaoPagamento = data;
            alert("id Da Sessão de Pagamento: "+ $idSessaoPagamento);
            var hashUser ="";
            PagSeguroDirectPayment.setSessionId($idSessaoPagamento);

            hashUser = PagSeguroDirectPayment.getSenderHash();
            alert("Passando hash: "+ hashUser);

            var tokenc="";
            var mes = $("#validadeMes").val();
            var ano = "20"+$("#validadeAno").val();

            //alert("Data: mes:"+mes+" - Ano:"+ano);
            var a = $("#numcartao").val();
            var bin = a.substr(0,6);

            var bandeira="";
            PagSeguroDirectPayment.getBrand({
                cardBin: bin,
                success: function(response) {
                    //bandeira encontrada
                    console.log(response);
                    bandeira = response.brand.name;
                    alert("Bandeira:"+bandeira);
                },
                error: function(response) {
                    //tratamento do erro
                    console.log(response);
                },
                complete: function(response) {
                    //tratamento comum para todas chamadas
                }
            });


            var param = {
                cardNumber: $("#numcartao").val(),
                brand: bandeira,
                cvv: $("#cvv").val(),
                expirationMonth: mes,
                expirationYear: ano,
                success: function(response) {
                    console.log(response);
                    tokenc = response.card.token;
                    alert("Dados do HASH: "+hashUser+ " - TOKEN CARTÃO: "+tokenc+"Bandeira"+bandeira);

                    localStorage.setItem('cpf',$('#cpfcartao').val());
                    localStorage.setItem('nomecartao',$('#nomecartao').val());
                    localStorage.setItem('datanascimento',$('#datanascimentocartao').val());
                    localStorage.setItem('email',$('#emailcomprador').val());
                    localStorage.setItem('rua',$('#ruacomprador').val());
                    localStorage.setItem('cidade',$('#cidadecomprador').val());
                    localStorage.setItem('bairro',$('#bairrocomprador').val());
                    localStorage.setItem('estado',$('#estadocomprador').val());
                    localStorage.setItem('ddd',$('#dddcomprador').val());
                    localStorage.setItem('telefone',$('#telefonecomprador').val());
                    localStorage.setItem('numero',$('#numcomprador').val());
                    localStorage.setItem('cep',$('#cepcomprador').val());



                    $.post("recebedados.php",{
                        hashuser: hashUser,
                        tokencartao:tokenc,
                        brand:bandeira,
                        cpf:$('#cpfcartao').val(),
                        nomecartao: $('#nomecartao').val(),
                        datanascimento: $('#datanascimentocartao').val(),
                        email: $('#emailcomprador').val(),
                        rua: $('#ruacomprador').val(),
                        cidade: $('#cidadecomprador').val(),
                        bairro: $('#bairrocomprador').val(),
                        estado: $('#estadocomprador').val(),
                        ddd: $('#dddcomprador').val(),
                        telefone: $('#telefonecomprador').val(),
                        numero : $('#numcomprador').val(),
                        cep : $('#cepcomprador').val(),
                        idsessao:$idSessaoPagamento
                    }, function(datar){
                        console.log(datar);
                        alert("Resultado:"+datar);
                    });


                },
                error: function(response) {
                    //tratamento do erro
                    console.log(response);
                },
                complete: function(response) {
                    //tratamento comum para todas chamadas
                    console.log(response);
                }
            };


            PagSeguroDirectPayment.createCardToken(param);
        });
    }


</script>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

